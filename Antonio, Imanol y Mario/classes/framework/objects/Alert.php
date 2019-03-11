<?php

namespace framework\objects;

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
    
    static function getMessage($operacion, $resultado) {
        $alert = new Alert($operacion, $resultado);
        return $alert->getAlert();
    }
}