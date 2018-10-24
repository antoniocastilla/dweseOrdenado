<?php

require 'classes/Autoload.php';

$op = Reader::get('op');
$mensaje = '';
if($op !== null) {
    $mensaje = '<h5>El resultado de ' . $op . ' es ' . Reader::get('resultado') . '</h5>';
}

$directorio = opendir('../../../privado/');
$nombres = array();
$fotos = array();

while ($archivo = readdir($directorio)){
    if (!is_dir($archivo)){
        $info = pathinfo($archivo);
        $nombres[] = $info['filename'];
        $fotos[] = $info['basename'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
    <div id="wrapper">
        <?= $mensaje ?>
        <h1>USER LIST</h1>
        <hr>
        <ul>
            <?php
                foreach($nombres as $index=>$nombre){
            ?>
            <li><a href="Read.php?nombre=<?= $fotos[$index] ?>" target="_onblank"><?= $nombre ?></a></li>
             <?php  
            }
            ?>
        </ul>
        <a href="agrega.html"><img src="add.png"></img></a>
    </div>
</body>
</html>
