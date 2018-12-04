<?php

use izv\app\App;
use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;

require '../classes/autoload.php';

$sesion = new Session(App::SESSION_NAME);
$sesion->logout();

$resultado = Reader::read('resultado');
$op = Reader::read('op');

header('Location: ' . '/proyectousuarios/index.php?op=' . $op . '&resultado=' . $resultado);
