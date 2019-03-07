<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;

class MainController extends Controller {
    
    /*
    Proceso general:
    1º Control de sesión
    2º Lectura de datos
    3º Validación de datos
    4º Usar el modelo
    5º Producir resultado (para la vista)
    */
    
    function __construct(Model $model) {
        parent::__construct($model);
        
    }
    
    function main() {
        //1º control de sesión
        if($this->getSession()->isLogged()) {
            $this->getModel()->set('twigFile', 'indexlogged.twig');
            $this->getModel()->set('user', $this->getSession()->getLogin()->getCorreo());
            if($this->isAdministrator()) {
                $this->getModel()->set('administrador', true);
            }
        } else {
            //5º producir resultado
            $this->getModel()->set('twigFile', 'index.twig');
        }
    }
    
    private function isAdministrator() {
        return $this->getSession()->isLogged() && $this->getSession()->getLogin()->getCorreo() === 'admin@admin.es';
    }
    
}