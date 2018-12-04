<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\app\App;
use izv\tools\Alert;
use izv\tools\Session;
use izv\tools\Util;
use izv\tools\Mail;
use izv\database\Database;
use izv\managedata\ManageUsuario;

$usuario = Reader::readObject('izv\data\Usuario');
$clave2 = Reader::read('clave2');

if($usuario == null || $clave2 == null) {
    header('Location: ../index.php');
    exit();
}

if($usuario->getClave() !== $clave2) {
    header('Location: register.php?op=dataregister&resultado=0');
    exit();
}

$usuario->setActivo(0);
$usuario->setAdmin(0);
$usuario->setClave(Util::encriptar($usuario->getClave()));

$db = new Database();
$manager = new ManageUsuario($db);
$resultado = $manager->add($usuario);
$db->close();

$resultado2 = 0;
if($resultado > 0) {
    $usuario->setId($resultado);
    $resultado2 = Mail::sendActivation($usuario);
}

$url = Util::url() . '../index.php?op=insert&resultado=' . $resultado . '&mail=' . $resultado2;
header('Location: ' . $url);

