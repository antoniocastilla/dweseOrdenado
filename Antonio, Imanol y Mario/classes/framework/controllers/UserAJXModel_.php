<?php

namespace framework\controllers;

use framework\app\App;
use framework\objects\dbobjects\Usuario;
use framework\models\Model;
use framework\objects\Reader;
use framework\objects\Session;
use framework\classes\Util;

class UserController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        //...
    }

    /*
    proceso general:
    1º control de sesión
    2º lectura de datos
    3º validación de datos
    4º usar el modelo
    5º producir resultado (para la vista)
    */

    function ciudades() {

    }

    function dologin() {
        //1º control de sesión
        if($this->getSession()->isLogged()) {
            //5º producir resultado -> redirección
            header('Location: ' . App::BASE . 'index?op=login&r=session');
            exit();
        }

        //2º lectura de datos
        $usuario = Reader::readObject('izv\data\Usuario');
        
        //4º usar el modelo
        $r = $this->getModel()->login($usuario);

        if($r !== false) {
            $this->getSession()->login($r);
            $r = 1;
        } else {
            $r = 0;
        }
        
        //5º producir resultado -> redirección
        header('Location: ' . App::BASE . 'index?op=login&r=' . $r);
        exit();
    }

    function dologout() {
        $this->getSession()->logout();
        header('Location: ' . App::BASE . 'index');
        exit();
    }

    function doregister() {
        //1º control de sesión
        if($this->getSession()->isLogged()) {
            //5º producir resultado -> redirección
            header('Location: ' . App::BASE . 'index?op=register&r=session');
            exit();
        }

        //2º lectura de datos
        $usuario = Reader::readObject('izv\data\Usuario');
        $clave2 = Reader::read('clave2');

        //3º validación de datos
        if($usuario->getClave() !== $clave2 ||
            mb_strlen($usuario->getClave()) < 4) {
            //5º producir resultado -> redirección
            header('Location: ' . App::BASE . 'index?op=register&r=password');
            exit();
        }
        if (!filter_var($usuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
            //5º producir resultado -> redirección
            header('Location: ' . App::BASE . 'index?op=register&r=email');
            exit();
        }

        //4º usar el modelo
        $usuario->setClave(Util::encriptar($usuario->getClave()));
        $r = $this->getModel()->register($usuario);

        //5º producir resultado -> redirección
        header('Location: ' . App::BASE . 'index?op=register&r=' . $r);
        exit();
    }

    function login($correo, $clave) {
        $gestor = $this->getDatabase();
        $usuario = $gestor->getRepository('framework\dbobjects\Usuario')->findOneBy(array('correo' => $correo));
        if($usuario !== null) {
            $resultado = \framework\classes\Util::verificarClave($clave, $usuario->getClave());
            
            if($resultado) {
                $usuario->setClave('');
                //Alejandro dixit
                //$this->set('usuario', $usuario->get());
                return $usuario;
            }
        }
        return false;
    }

    function defaultAction() {
        //1º control de sesión
        if($this->getSession()->isLogged()) {
            $this->getModel()->set('twigFile', 'page-user.html');
            $this->getModel()->set('user', $this->getSession()->getLogin()->getCorreo());
            if($this->isAdministrator()) {
                $this->getModel()->set('administrador', true);
            }
        } else {
            //5º producir resultado
            $this->login();
            
        }
    }

    function otra() {
        $this->getModel()->set('twigFile', '_otra.html');
    }

    function register() {
        //1º control de sesión, si está logueado no se muestra el registro
        if(!$this->getSession()->isLogged()) {
            //5º producir resultado
            $this->getModel()->set('twigFile', '_register.html');
        }
    }
    
    
    
    
    
}