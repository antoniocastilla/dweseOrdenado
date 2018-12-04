<?php

use izv\app\App;
use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Util;

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

$id = Reader::read('id');
$code = Reader::read('code');

$sendedMail = \Firebase\JWT\JWT::decode($code, App::JWT_KEY, array('HS256'));

$db = new Database();
$manager = new ManageUsuario($db);
$user = $manager->get($id);

$resultado = 0;
if($user !== null && $user->getCorreo() === $sendedMail) {
    $user->setActivo(1);
    $resultado = $manager->edit($user);
}
$url = Util::url() . '../index.php?op=activate&resultado=' . $resultado;
header('Location: ' . $url);