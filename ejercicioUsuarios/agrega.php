<?php

require('../classes/Upload.php');
$r = '0';
$archivo = new Upload('foto');
$archivo->setPolicy(Upload::POLICY_KEEP);
$archivo->setTarget('../../../privado/');
$archivo->setName($_POST['nombre']);
$result = $archivo->upload();
if ($result){
    $r = $result;
}

$url = 'index.php?op=addUser&resultado=' . $r;
header('Location: ' . $url);