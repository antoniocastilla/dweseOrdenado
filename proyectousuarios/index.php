<?php
require 'classes/autoload.php';
require_once("classes/vendor/autoload.php");

use izv\app\App;
use izv\tools\Alert;
use izv\tools\Reader;
use izv\tools\Util;
use izv\tools\Session;


// Specify our Twig templates location
// Instantiate our Twig
$loader = new \Twig_Loader_Filesystem(__DIR__ . '/plantillas/');
$twig = new \Twig_Environment($loader);

$sesion = new Session(App::SESSION_NAME);
$logged = $sesion->isLogged();


$alert = Alert::getMessage(Reader::get('op'), Reader::get('resultado'));
// PlaceHolder
$data = array('title' => 'Home',
                'logged' => $logged,
                'alert' => $alert);

if ($logged) {
    $usuario = $sesion->getLogin();
    //echo Util::varDump($usuario);exit();
    $data['usuario'] = $usuario;
    if (!$usuario->getActivo()) {
        header('Location: ' . 'usuario/dologout.php');
        exit();
    }
}

echo $twig->render('home.twig', $data);