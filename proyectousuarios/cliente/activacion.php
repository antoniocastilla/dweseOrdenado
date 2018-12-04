<?php

//Página para activar usuario

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Util;

require '../classes/autoload.php';

$db = new Database();
$manager = new ManageUsuario($db);
$id = Reader::read('id');

if($id !== null) {
    if(!is_numeric($id) ||  $id <= 0) {
        header('Location: index.php');
        exit();
    }
    $resultado = $manager->enableUser($id);
}
$db->close();
$url = Util::url() . 'index.php?op=enableusuario&resultado=' . $resultado;
header('Location: ' . $url);
