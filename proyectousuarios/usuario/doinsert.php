<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\app\App;
use izv\tools\Session;
use izv\tools\Util;
use izv\tools\Mail;
use izv\database\Database;
use izv\managedata\ManageUsuario;

$usuario = Reader::readObject('izv\data\Usuario');
$sesion = new Session(App::SESSION_NAME);
//echo Util::varDump($usuario);exit();

if(!$sesion->isLogged() || $usuario == null || $sesion->getLogin()->getAdmin() == 0) {
    header('Location: ../index.php');
    exit();
}

if($usuario->getAlias() === '') {
    $usuario->setAlias(null);
}

if(!$usuario->getActivo()) {
    Mail::sendActivation($usuario);
}

$db = new Database();
$manager = new ManageUsuario($db);
$usuario->setClave(Util::encriptar($usuario->getClave()));

$resultado = $manager->add($usuario);
$db->close();

/*
echo Util::varDump($db->getConnection()->errorInfo());
echo Util::varDump($db->getSentence()->errorInfo());
*/

$url = 'index.php?op=insertusuario&resultado=' . $resultado;
header('Location: ' . $url);