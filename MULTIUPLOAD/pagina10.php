<?php
require('classes/Autoload.php');
/*
Cuántos archivos venían y cuántos ha podido subir
Si le pido el nombre me tiene que da los nombres con los que guarda los archivos
El keep se queda con el prime archivo
el overwrite con el ultimo
Y con el rename con todos, por lo que al cambiar el nombre se lo cambio a todos
El maxSize es solo para uno
*/
$archivo = new Upload('archivo');
$archivo->setPolicy(Upload::POLICY_RENAME);
$r = $archivo->upload();

/***************************************/
echo '<pre>' . var_export($_FILES['archivos'], true) . '</pre>';
echo '<hr>';
$archivos = new UploadMultiple('archivos');
$archivos->setPolicy(UploadMultiple::POLICY_RENAME);
echo $archivos->upload();
echo Util::varDump($archivos->getNames());

//$archivo = new UploadMultiple('archivos');
//$r = $archivo->upload();