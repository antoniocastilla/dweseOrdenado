<?php

trait Comun {

    function __toString() {
        $string = get_class() . ': ';
        foreach($this as $atributo => $valor) {
            $string .= $atributo . ' = ' . $valor . '<br>';
        }
        return $string;
    }
    
    function fetch(array $array, $initial = 0) {
        $contador = $initial;
        foreach($this as $atributo => $valor) {
            if(isset($array[$contador])) {
                $this->$atributo = $array[$contador];
            }
            $contador++;
        }
        return $this;
    }
    
    function get() {
        $array = array();
        foreach($this as $atributo => $valor) {
            $array[$atributo] = $valor;
        }
        return $array;
    }

    function introspeccion() {
        foreach($this as $atributo => $valor) {
            echo $atributo . ': ' . $valor . '<br>';
        }
    }
    
    function set(array $array) {
        foreach($this as $atributo => $valor) {
            if(isset($array[$atributo])) {
                $this->$atributo = $array[$atributo];
            }
        }
        return $this;
    }
    
    function merge(array $array) {
        foreach($array as $atributo => $valor) {
            if(property_exists($this, $atributo)) {
                $this->$atributo = $valor;
            }
        }
        return $this;
    }
    
    //metodoGet -> array asociativo cuyos indices son los atributos del objeto -> fetch//get
    //metodoSet(array) -> asignar los valores del array asociativo al objeto   -> merge//set
    
    
}