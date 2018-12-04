<?php
require '../classes/autoload.php';
require '../classes/vendor/autoload.php';

use izv\tools\Session;

$sesion = new Session();

$origen = "wherethepartyisover@gmail.com";
$alias = "Dudu";
$destino = "damcurso1819@gmail.com";
$asunto = "Soy Dudu desde el Bronx";
$mensaje = "¿Llegará?";
$cliente = new Google_Client();

$cliente->setApplicationName('Proyecto 1');
$cliente->setClientId('1051145849970-ukis285kslusn2end994s6gf0ntcqnnt.apps.googleusercontent.com');
$cliente->setClientSecret('1iKUlLsO1Ltz2fSlLTKJ9E6p');

$cliente->setAccessToken(file_get_contents('token.conf'));
if ($cliente->getAccessToken()) {
    $service = new Google_Service_Gmail($cliente);
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->From = $origen;
        $mail->FromName = $alias;
        $mail->AddAddress($destino);
        $mail->AddReplyTo($origen, $alias);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->preSend();
        $mime = $mail->getSentMIMEMessage();
        $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
        $mensaje = new Google_Service_Gmail_Message();
        $mensaje->setRaw($mime);
        $service->users_messages->send('me', $mensaje);
        echo "Correo enviado correctamente";
    } catch (Exception $e) {
        echo ("Error en el envío del correo: " . $e->getMessage());
    }
} else {
    echo "No conectado con gmail";
}