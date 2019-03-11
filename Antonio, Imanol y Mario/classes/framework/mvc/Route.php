<?php

namespace framework\mvc;

class Route {

    private $modelo, $vista, $controlador;

    function __construct($modelo, $vista, $controlador) {
        $this->modelo = $modelo;
        $this->vista = $vista;
        $this->controlador = $controlador;
    }
    
    function getController() {
        return 'framework\\controllers\\' . $this->controlador;
    }

    function getModel() {
        //return 'framework\\models\\' . $this->modelo;
        return 'framework\\models\\' . $this->modelo;
    }

    function getView() {
        //return 'framework\\views\\' . $this->vista;
        return 'framework\\views\\' . $this->vista;
    }
}