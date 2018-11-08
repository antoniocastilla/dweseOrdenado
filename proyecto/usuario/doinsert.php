<?php

require '../classes/autoload.php';

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Util;

$db = new Database();
$manager = new ManageUsuario($db);
$usuario = Reader::readObject('izv\data\Usuario');
echo Util::varDump($usuario);
$resultado = $manager->add($usuario);
$db->close();
$url = 'index.php?op=insertusuario&resultado=' . $resultado;
header('Location: ' . $url);