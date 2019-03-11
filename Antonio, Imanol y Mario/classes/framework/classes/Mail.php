<?php

namespace framework\classes;

use framework\app\App;
use framework\dbobjects\Usuario;
use framework\classes\Util;

class Mail {

    static function sendActivation(Usuario $usuario) {
        $asunto = '8Beast Shoe Store - Account activated';
        $jwt = \Firebase\JWT\JWT::encode($usuario->getCorreo(), App::JWT_KEY);
        $enlace = Util::url() . 'activar?id='. $usuario->getId() .'&code=' . $jwt;
        $mensaje = "Activation email for ". $usuario->getNombre();
        $mensaje .= '<br><a href="' . $enlace . '">Activate account</a>';
        return self::sendMail($usuario->getCorreo(), $asunto, $mensaje);
    }
    
    
    
    static function sendOrderMessage($order, Usuario $usuario) {
        $asunto = '8Beast Shoe Store - Order Confirmed';
        //$jwt
        $enlace = Util::url() . 'user';
        $mensaje = $order;
        $mensaje .= '<br><a href="' . $enlace . '">Ver</a>';
        return self::sendMail($usuario->getCorreo(), $asunto, $mensaje);
    }
    
    static function sendMail($destino, $asunto, $mensaje) {

        $cliente = new \Google_Client();
        $cliente->setApplicationName(App::EMAIL_APPLICATION_NAME);
        $cliente->setClientId(App::EMAIL_CLIENT_ID);
        $cliente->setClientSecret(App::EMAIL_CLIENT_SECRET);
        $cliente->setAccessToken(file_get_contents(App::EMAIL_TOKEN_FILE));

        $result = false;
        if ($cliente->getAccessToken()) {
            $service = new \Google_Service_Gmail($cliente);
            try {
                $mail = new \PHPMailer\PHPMailer\PHPMailer();
                $mail->CharSet = "UTF-8";
                $mail->From = App::EMAIL_ORIGIN;
                $mail->FromName = App::EMAIL_ALIAS;
                $mail->AddAddress($destino);
                $mail->AddReplyTo(App::EMAIL_ORIGIN, App::EMAIL_ALIAS);
                $mail->Subject = $asunto;
                $mail->IsHTML(true);
                $mail->Body = $mensaje;
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new \Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $service->users_messages->send('me', $mensaje);
                $result = true;
            } catch (Exception $e) {
            }
        } else {
        }
        return $result;
    }
}