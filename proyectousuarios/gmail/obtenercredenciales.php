<?php
session_start();
require '../classes/vendor/autoload.php';
$cliente = new Google_Client();

$cliente->setApplicationName('Proyecto 1');
$cliente->setClientId('1051145849970-ukis285kslusn2end994s6gf0ntcqnnt.apps.googleusercontent.com');
$cliente->setClientSecret('1iKUlLsO1Ltz2fSlLTKJ9E6p');
$cliente->setRedirectUri('https://dwse-antoniocastilla.c9users.io/proyecto/gmail/obtenercredenciales.php');

$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (isset($_GET['code'])) {
    $cliente->authenticate($_GET['code']);
    $_SESSION['token'] = $cliente->getAccessToken();
    $archivo = "token.conf";
    $fh = fopen($archivo, 'w') or die("error");
    fwrite($fh, json_encode($cliente->getAccessToken()));
    fclose($fh);
    header("Location: finalizartoken.php?code=" . $_GET['code']);
}