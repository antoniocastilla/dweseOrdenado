<?php

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Util;
use izv\tools\Mail;
use izv\tools\Session;
use izv\app\App;

require '../classes/autoload.php';
require_once('../classes/vendor/autoload.php');

// Sesion
$sesion = new Session(App::SESSION_NAME);

//Comprobar si puedo hacer esta operacion
$resultado = 0;
if(!$sesion->isLogged()) {
    $url = Util::url() . '/proyectousuarios/index.php?op=login&resultado=' . $resultado;
    header('Location: ' . $url);
    exit();
}

$id = Reader::read('id');
if($id == null || !is_numeric($id) || $id <= 0) {
    $url = '/proyectousuarios/index.php';
    header('Location: ' . $url);
    exit();
}
$db = new Database();
$manager = new ManageUsuario($db);
$usuario = $manager->get($id);
if ($usuario === null) {
    header('Location: ' . 'index.php?op=userfound&resultado=0');
    exit();
}
$db->close();

$op = 'edituser';
$changepassword = false;
$baja = false;

$clavesDiferentes = false;
$clave = Reader::read('clave');
$claveNueva = '';
if ( $clave != null) {
    $op = 'editclave';
    $claveCorrecta = Util::verificarClave($clave, $usuario->getClave());
    if ($claveCorrecta) {
        if ($clave !== Reader::read('clave1') & Reader::read('clave1') === Reader::read('clave2')) {
            $clavesDiferentes = true;
            $changepassword = true;    
            $usuario->setClave(Reader::read('clave1'));
        }
    }
} else {
    $option = Reader::read('baja');
    if (isset($option)) {
        $baja = true;
    }
}

$url = Util::url() . 'index.php?op='. $op . '&resultado=' . $resultado;

$resultado = 0;
if($changepassword && $clavesDiferentes) {
    $usuario->setClave(Util::encriptar($usuario->getClave()));
    $resultado = $manager->editWithPassword($usuario);
    // Sobreescribimos la sesión si hemos hecho cambios en nuestra cuenta.
    if($resultado && $usuario->getId() ===  $sesion->getLogin()->getId()) {
        $sesion->login($usuario);
    }
} else {
    $op = 'removeaccount';
    if ($option === 'option1') {
        $usuario->setActivo(0);
        $resultado = $manager->edit($usuario);
    } else {
        if ($option === 'option2') {
            $resultado = $manager->remove($usuario->getId());
        }
    }
    if ($resultado) {
        $sesion->logout();
        $url = Util::url() . 'dologout.php?op='. $op . '&resultado=' . $resultado;
    }
}

header('Location: ' . $url);
