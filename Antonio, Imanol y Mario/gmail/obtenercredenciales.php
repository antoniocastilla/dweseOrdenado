<?php
session_start();
require_once '../classes/vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('correoDWES');
$cliente->setClientId('57979040865-683aq00432672sr9n91nphc2ff36hk9v.apps.googleusercontent.com');
$cliente->setClientSecret('gqC1Q8cFH5vifrU2jDRHWDdx');
$cliente->setRedirectUri('https://dwse-hisouten.c9users.io/proyecto/gmail/obtenercredenciales.php');
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