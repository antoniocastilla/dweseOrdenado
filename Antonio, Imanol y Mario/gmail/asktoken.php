<?php
/*SEEMS OK*/

session_start();

require_once '../classes/vendor/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('SocialMailer');
$cliente->setClientId('269657292859-88df0agt4sumv2cpiqee0dpn5hpeldu5.apps.googleusercontent.com');
$cliente->setClientSecret('hsvRG0NfMIg1txJa-28P-IAZ');
$cliente->setRedirectUri('https://servidor-proyecto-superwave.c9users.io/gmail/getcredentials.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');
if (!$cliente->getAccessToken()) {
    $auth = $cliente->createAuthUrl();
    header("Location: $auth");
}