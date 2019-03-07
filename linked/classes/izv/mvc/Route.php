<?php

namespace izv\mvc;

class Route {

    private $modelo, $vista, $controlador;

    function __construct($modelo, $vista, $controlador) {
        $this->modelo = $modelo;
        $this->vista = $vista;
        $this->controlador = $controlador;
    }
    
    function getController() {
        return 'izv\controller\\' . $this->controlador;
    }

    function getModel() {
        return 'izv\model\\' . $this->modelo;
    }

    function getView() {
        return 'izv\view\\' . $this->vista;
    }
}