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
$clave = Reader::read('clave');
if ( $clave !== '') {
    $changepassword = true;
    $usuario->setClave($clave);
} 

$resultado = 0;
if($changepassword) {
    $usuario->setClave(Util::encriptar($usuario->getClave()));
    $resultado = $manager->editWithPassword($usuario);
} 

$url = Util::url() . 'index.php?op='. $op . '&resultado=' . $resultado;
header('Location: ' . $url);
