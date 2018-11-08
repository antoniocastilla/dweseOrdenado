<?php

require '../classes/autoload.php';

use izv\data\Producto;
use izv\database\Database;
use izv\managedata\ManageProducto;
use izv\tools\Reader;
use izv\tools\Util;

$db = new Database();
$manager = new ManageProducto($db);
$producto = Reader::readObject('izv\data\Producto');
echo Util::varDump($producto);
$resultado = $manager->add($producto);
$db->close();
$url = 'index.php?op=insertproducto&resultado=' . $resultado;
header('Location: ' . $url);