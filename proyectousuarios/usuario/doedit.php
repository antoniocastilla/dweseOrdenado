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
if(!$sesion->isLogged()) {
    $url = Util::url() . '/proyectousuarios/index.php?op=login&resultado=0';
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
$db->close();

foreach($usuario->get() as $i => $valor) {
    $campo = Reader::read($i);
    if ($campo !== null) {
        //echo '<br> He leido: ' . $i . ' con valor: ' . Reader::read($i);
        if ($i == 'correo') {
            if ($campo !== $usuario->getCorreo()) {
                $changemail = true;
                $metodo = 'set' . ucfirst($i);
                $usuario->$metodo($campo);
            }
        } else {
            $metodo = 'set' . ucfirst($i);
            $usuario->$metodo($campo);
        }
    }
}

//echo '<br>' . Util::varDump($usuario);exit();

$usuario->setClave('');
$op = 'edituser';
if ($changemail) {
    $usuario->setActivo(0);
    Mail::sendActivation($usuario);
    $op = 'editcorreo';
}
$resultado = $manager->edit($usuario);

// Sobreescribimos la sesión si hemos hecho cambios en nuestra cuenta.
if($resultado && $usuario->getId() ===  $sesion->getLogin()->getId()) {
    $sesion->login($usuario);
}

$url = Util::url() . 'index.php?op='. $op . '&resultado=' . $resultado;
header('Location: ' . $url);
