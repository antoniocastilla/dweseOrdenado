<?php

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Util;
use izv\tools\Session;
use izv\app\App;

require '../classes/autoload.php';
require_once('../classes/vendor/autoload.php');


// Cargamos las plantillas
// Cargamos el Cargador
$loader = new \Twig_Loader_Filesystem('../plantillas');
$twig = new \Twig_Environment($loader);

// Sesion
$sesion = new Session(App::SESSION_NAME);
//Comprobar si puedo hacer esta operacion
if(!$sesion->isLogged()) {
    $url = Util::url() . '/proyectousuarios/index.php';
    header('Location: ' . $url);
    exit();
}

//2º Validar los Datos
$yo = $sesion->getLogin();
$usuario = $sesion->getLogin();
$id = Reader::read('id');
//Si el id no es nulo y somos administradores podemos editarlo
if($id !== null && $usuario->getAdmin()) {
    $db = new Database();
    $manager = new ManageUsuario($db);
    $usuario = $manager->get($id);
}
//Si no somos administradores, nos aseguramos
//de editarnos solo a nosotros
    
    
$resultado = Reader::read('resultado');
$op = Reader::read('op');
$alert = Alert::getMessage($op, $resultado);

$data = array ('title' => 'Editar información de usuario',
                'logged' => $sesion->isLogged(),
                'alert' => $alert,
                'usuario' => $usuario->get()
                );

//Renderizado
if($yo->getAdmin()) {
    echo $twig->render('editRoot.twig', $data);
} else {
    echo $twig->render('editSelf.twig', $data);
}