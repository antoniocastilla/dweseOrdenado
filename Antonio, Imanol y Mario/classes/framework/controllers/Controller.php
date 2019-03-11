<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Session;
use framework\objects\Carrito;

class Controller {

    /*
    proceso general:
    1º control de sesión
    2º lectura de datos
    3º validación de datos
    4º usar el modelo
    5º producir resultado (para la vista)
    */

    private $model;
    private $sesion;

    function __construct(Model $model) {
        $this->model = $model;
        $this->sesion = new Session(App::SESSION_NAME);
        $this->getModel()->set('urlbase', App::BASE);
        $this->getModel()->set('logged', $this->getSession()->isLogged());
        
        if(!$this->sesion->hasCart()) {
            $cart = new Carrito();
            $this->sesion->newCart($cart);
        }
    }
    
    function isLogged() {
        if ($this->getSession()->isLogged()) {
            return true;
        }
        return false;
    }
    
    function isAdministrator() {
        if ($this->isLogged()) {
            if ($this->getSession()->getLogin()->getAdministrador()) {
                return true;
            }
        }
        return false;
    }
    
    function __checkLogged($redirect = '') {
        if (!$this->isLogged()) {
            header('Location:' . App::BASE . $redirect);
            exit;
        }
    }
    
    function __checkAdmin() {
        if (!$this->isLogged()) {
            header('Location:' . App::BASE . 'user');
            exit;
        } else {
            if (!$this->isAdministrator()) {
                header('Location:' . App::BASE . 'index');
                exit;
            }
        }
    }
    
    function getModel() {
        return $this->model;
    }
    
    function getSession() {
        return $this->sesion;
    }

    /* acciones */
    
    function main() {
        //El usuario no debería llegar aqui
        $this->getModel()->set('datos', 'datos que envía el método main');
    }
    
    function getNiceArray($items = null) {
        $its;
        if ($items !== null) {
            $its = [];
            foreach ($items as $item) {
                $its[] = $item->get();
            }
        }
        return $its;
    }
    
    
    
    /* GENERAL FUNCTIONS */


}