<?php

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Util;

require '../classes/autoload.php';

$db = new Database();
$manager = new ManageUsuario($db);
$usuario = Reader::readObject('izv\data\Usuario');
$usuario->setFechaalta(date('Y-m-d G:i:s'));
$resultado = $manager->edit($usuario);
$db->close();
$url = Util::url() . 'index.php?op=editusuario&resultado=' . $resultado;
//header('Location: ' . $url);
Util::varDump($usuario);
?>

<a href="<?= $url ?>">Seguir</a>