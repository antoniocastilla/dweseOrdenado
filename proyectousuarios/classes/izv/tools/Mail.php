<?php

namespace izv\tools;

use izv\app\App;
use izv\data\Usuario;
use izv\tools\Util;

class Mail {

    static function sendActivation(Usuario $usuario) {
        $asunto = 'Correo de activación de la App: DWES IZV';
        $jwt = \Firebase\JWT\JWT::encode($usuario->getCorreo(), App::JWT_KEY);
        $enlace = Util::url() . 'doactivar.php?id='. $usuario->getId() .'&code=' . $jwt;
        $mensaje = "Correo de activación para:  ". $usuario->getNombre();
        $mensaje .= '<br><a href="' . $enlace . '">activar cuenta</a>';
        return self::sendMail($usuario->getCorreo(), $asunto, $mensaje);
    }

    static function sendActivationMio(Usuario $usuario) {
        $userMail = $usuario->getCorreo();
        $mensaje = "Correo de activación para la cuenta del usuario ". $usuario->getAlias() .'<br>';
        $mensje = $mensaje . 'Para activar tu cuenta visita el siguiente enlace:  ';
        $mensaje = $mensaje . 'https://dwse-antoniocastilla.c9users.io/proyectousuarios/cliente/activacion.php?correo=' . $usuario->getCorreo();
        $asunto = 'Correo de activación para el foro de clase';
        return self::sendMail($userMail, $asunto, $mensaje);
    }
    
    static function sendReActivation(Usuario $usuario) {
        $userMail = $usuario->getCorreo();
        $mensaje = "Correo de re-activación de ". $usuario->getAlias() .'<br>';
        $mensje = $mensaje . 'Has cambiado tu contraseña, para activar tu cuenta visita el siguiente enlace:  ';
        $mensaje = $mensaje . ' https://dwse-antoniocastilla.c9users.io/proyectousuarios/cliente/activacion.php?id=' . $usuario->getId();
        $asunto = 'Activa de nuevo tu cuenta';
        return self::sendMail($userMail, $asunto, $mensaje);
    }
    
    static function sendMail($destino, $asunto, $mensaje) {
        
        $cliente = new \Google_Client();
        
        $cliente->setApplicationName(App::EMAIL_APPLICATION_NAME);
        $cliente->setClientId(App::EMAIL_CLIENT_ID);
        $cliente->setClientSecret(App::EMAIL_CLIENT_SECRET);
        
        $cliente->setAccessToken(file_get_contents(App::EMAIL_TOKEN_FILE));
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
                $mail->Body = $mensaje;
                $mail->preSend();
                $mime = $mail->getSentMIMEMessage();
                $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
                $mensaje = new \Google_Service_Gmail_Message();
                $mensaje->setRaw($mime);
                $service->users_messages->send('me', $mensaje);
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }
}