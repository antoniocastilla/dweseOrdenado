<?php

namespace izv\tools;

class Alert {
    
    private $operacion, $resultado;
    
    static private $mensajes = array(
        'activate' => array(
            'No se ha podido activar.',
            'Se ha activado correctamente.'
        ),
        'delete' => array(
            'No se ha podido borrar.',
            'Se ha borrado correctamente.'
        ),
        'deleteproducto' => array(
            'No se ha podido borrar el producto.',
            'El producto se ha borrado correctamente.'
        ),
        'edit'   => array(
            'No se ha podido modificar.',
            'Se ha modificado correctamente.'
        ),
        'editproducto'   => array(
            'No se ha podido modificar el producto.',
            'El producto se ha modificado correctamente.'
        ),
        'insert' => array(
            'No se ha podido insertar.',
            'Se ha insertado correctamente.'
        ),
        'insertproducto' => array(
            'No se ha podido insertar el producto.',
            'El producto se ha insertado correctamente.'
        ),
        'login' => array(
            'No se ha autentificado correctamente.',
            'Logueado correctamente.'
        ),
        'activo' => array(
            'Usuario no activado.',
            'Usuario activado.'
        ),
        'register' => array(
            'No se ha registrado correctamente.',
            'Registrado correctamente.'
        ),
        'edituser' => array(
            'No se han hecho cambios de la informacion de usuario.',
            'Se ha podido editar la información de usuario.'
        ),
        'editcorreo' => array(
            'No se ha podido cambiar el correo electrónico',
            'Se ha cambiado el correo, para activar la cuenta revise 
                el e-mail que se ha enviado a la nueva dirección.',
        ),
        'editclave' => array(
            'No se ha podido cambiar la clave.',
            'Se ha cambiado la clave de acceso.',
        ),
        'removeaccount' => array(
            'No se ha podido eliminar o dar de baja la cuenta.',
            'Se ha eliminado o dado de baja la cuenta.',
        ),
        'userfound' => array(
            'No se ha podido acceder al usuario.',
            '',
        ),
        'insertusuario' => array(
            'No se ha podido insertar el usuario',
            'El usuario ha sido creado.'
        ),
        'dataregister' => array(
            'Los datos proporcionados no son válidos.',
            'Los datos proporcionados son validos.'
        )
    );
    
    static private $clases = array('alert-danger', 'alert-success');
    
    function __construct($operacion, $resultado) {
        $this->operacion = $operacion;
        $this->resultado = $resultado;
    }
    
    function getAlert() {
        $string = '';
        if(isset(self::$mensajes[$this->operacion])) {
            $pos = 1;
            if($this->resultado <= 0) {
                $pos = 0;
            }
            $clase = self::$clases[$pos];
            $mensaje = self::$mensajes[$this->operacion][$pos];
            $string = '<div class="alert ' . $clase . '" role="alert">' . $mensaje . '</div>';
        }
        return $string;
    }
    
    function getOnlyAlert($operacion, $resultado) {
        $alert = new Alert($operacion, $resultado);
        $string = '';
        if(isset(self::$mensajes[$alert->operacion])) {
            $pos = 1;
            if($alert->resultado <= 0) {
                $pos = 0;
            }
            $mensaje = self::$mensajes[$alert->operacion][$pos];
            $string = $mensaje;
        }
        return $string;
    }
    
    static function getMessage($operacion, $resultado) {
        $alert = new Alert($operacion, $resultado);
        return $alert->getAlert();
    }
}