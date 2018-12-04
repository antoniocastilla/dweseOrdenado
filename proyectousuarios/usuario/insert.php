<?php

require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\database\Database;
use izv\manager\ManageUsuario;
use izv\data\Usuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Tools;
use izv\tools\Session;
use izv\app\App;


// Cargamos las plantillas
// Cargamos el Cargador
$loader = new \Twig_Loader_Filesystem('../plantillas');
$twig = new \Twig_Environment($loader);

// Sesion
$sesion = new Session(App::SESSION_NAME);
$usuario = $sesion->getLogin();

$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

$data = array('title' => 'Registro de usuario',
              'alert' => $alert);

// Renderizado
if(!$sesion->isLogged()) {
    echo $twig->render('register.twig', $data);
} else if($sesion->isLogged() && $usuario->getAdmin()) {
    echo $twig->render('insertRoot.twig', $data);
} else {
    header('Location: ../index.php');
    exit();
}