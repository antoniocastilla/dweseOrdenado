<?php

namespace izv\controller;

use izv\app\App;
use izv\model\Model;
use izv\tools\Session;

class Controller {

    /*
    Proceso general:
    1º Control de sesión
    2º Lectura de datos
    3º Validación de datos
    4º Usar el modelo
    5º Producir resultado (para la vista)
    */

    private $model;
    private $sesion;

    function __construct(Model $model) {
        $this->model = $model;
        $this->sesion = new Session(App::SESSION_NAME);
        $this->getModel()->set('urlbase', App::BASE);
    }
    
    function getModel() {
        return $this->model;
    }
    
    function getSession() {
        return $this->sesion;
    }

    /* Actions */
    
    function main() {
        $this->getModel()->set('datos', 'datos que se enviarían');
    }

}