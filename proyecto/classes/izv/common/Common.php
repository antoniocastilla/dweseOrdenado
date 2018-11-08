<?php

namespace izv\common;

trait Common {

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

    /* alias de set, implementado de otro modo */
    function merge(array $array) {
        foreach($array as $atributo => $valor) {
            if(property_exists($this, $atributo)) {
                $this->$atributo = $valor;
            }
        }
        return $this;
    }

    function read($class = '\izvdwes\tools\Reader', $fetchMethod = 'fetchArray') {
        $array = $this->get();
        if(method_exists($class, $fetchMethod)) {
            $array = $class::$fetchMethod($array);
        }
        $this->set($array);
        return $this;
    }

    function set(array $array) {
        foreach($this as $atributo => $valor) {
            if(isset($array[$atributo])) {
                $this->$atributo = $array[$atributo];
            }
        }
        return $this;
    }

}