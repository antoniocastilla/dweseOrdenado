<?php
require('classes/Autoload.php');

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
