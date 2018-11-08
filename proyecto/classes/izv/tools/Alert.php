<?php

namespace izv\tools;

class Alert {
    
    private $operacion, $resultado;
    
    static private $mensajes = array(
        'insertproducto' => array('No se ha podido insertar el producto.', 'El producto se ha insertado correctamente.'),
        'deleteproducto' => array('No se ha podido borrar el producto.', 'El producto se ha borrardo correctamente.'),
        'editproducto' => array('No se ha podido modificar el producto.', 'El producto se ha modificado correctamente')
    );
        
    static private $clases = array('alert-danger', 'alert-success');
        
    function __construct($operacion, $resultado) {
        $this->operacion = $operacion;
        $this->resultado = $resultado;
    }
    
    function getAlert() {
        $pos = 1;
        if($this->resultado <= 0){
            $pos = 0;
        }
        $string = '';
        if (isset(self::$mensajes[$this->operacion])){
            $clase = self::$clases[$pos];
            $mensaje = self::$mensajes[$this->operacion][$pos];
            $string = '<div class="alert '. $clase . '" role="alert">' . $mensaje . '</div>';
        }
        return $string;
    }
    
    static function getMessage($operacion, $resultado) {
        $alert = new Alert($operacion, $resultado);
        return $alert->getAlert();
    }
}