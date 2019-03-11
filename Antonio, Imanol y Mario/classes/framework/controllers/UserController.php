<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Reader;
use framework\dbobjects\Usuario;
use framework\dbobjects\Categoria;
use framework\dbobjects\Link;
use framework\objects\Session;
use framework\classes\Util;
use framework\classes\Mail;

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
    
    //Acciones
    
    function activar() {
        if ($this->getSession()->isLogged()) {
           header('Location: ../user/dologout');
            exit; 
        }
        $id = Reader::read('id');
        $code = Reader::read('code');
        
        $resultado = $this->getModel()->activar($code, $id);
        
        $url = 'index?op=activate&r=' . $resultado;
        header('Location: ' . $url);
        exit();
    }

    function dologin() {
        if($this->getSession()->isLogged()) {
            header('Location: ' . App::BASE );
            exit();
        }
        
        $user = Reader::read('correo');
        $clave= Reader::read('clave');
        $redirect = Reader::read('redirect');
        if ($redirect == null || $redirect == '') {
            $redirect == 'user';
        }
        
        /*Util::varDump($user);
        Util::varDump($clave);*/
        $login = $this->getModel()->login($user, $clave);
        //Util::varDump($login);
        
        if($login) {
            $this->getSession()->login($login);
        } else {
            header('Location: '.App::BASE. 'user?op=login&r=0&redirect=checkout');
            exit();
        }
        
        
        header('Location: '.App::BASE.'user');
        exit();
    }

    function dologout() {
        $this->getSession()->logout();
        header('Location: ' . App::BASE . 'index');
        exit();
    }

    function doregister() {
        //1º control de sesión
        $this->getModel()->set('pagetitle', 'Account');
        if($this->getSession()->isLogged()) {
            //5º producir resultado -> redirección
            header('Location: ' . App::BASE);
            exit();
        }

        //2º lectura de datos
        $usuario = new Usuario();
        
        $usuario->setNickname(Reader::read('alias'));
        $usuario->setCorreo(Reader::read('correo'));
        $usuario->setClave(Reader::read('clave'));
        $usuario->setNombre(Reader::read('nombre'));
        $usuario->setApellidos(Reader::read('apellidos'));
        
        $usuario->setActivo(0);
        $usuario->setAdministrador(0);
        
        $repiteclave = Reader::read('repiteclave');

         if($usuario->getClave() !== $repiteclave ||
            mb_strlen($usuario->getClave()) < 4 ||
            !filter_var($usuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
            $resultado = 0;
        } else {
            $usuario->setClave(Util::encriptar($usuario->getClave()));
            $resultado = $this->getModel()->addUser($usuario);
            if ($resultado>0) {
                if($usuario->getId() != null) {
                    Mail::sendActivation($usuario);
                } else {
                    header('Location: ' . App::BASE . 'user/login?op=register&r=error');
                    exit;
                }
            }
        }


        //5º producir resultado -> redirección
        header('Location: ' . App::BASE . 'user/login?op=register&r=' . $resultado);
        exit();
    }

    //Visualizar paginas
    
    function defaultAction() {
        //1º control de sesión
        if($this->getSession()->isLogged()) {
            $this->getModel()->set('twigFile', 'page-useraccount.twig');
            $this->getModel()->set('user', $this->getSession()->getLogin()->getCorreo());
            if($this->getSession()->isAdministrator()) {
                $this->getModel()->set('administrador', true);
            }
            
            $curruser = $this->getSession()->getLogin();
            //echo $curruser->getFechaalta();exit;
        
            $cards = $this->getModel()->getSingleUserCards($curruser->getId());
            //Mostrar los datos de tarjeta y direccion y pedidos de ese usuario
            $addresses = $this->getModel()->getSingleUserAddress($curruser->getId());
            
            //Crea el error de DateTime<q   
            $orders = $this->getModel()->getSingleUserOrders($curruser->getId());
            
            $newcards = [];
            foreach ($cards as $c) {
                $newarr = $c->get();
                $newarr['fechaexpiracion'] = $c->getFechaexpiracion();
                
                $newcards[] = $newarr;
            }
            
            $neworders = [];
            foreach ($orders as $o) {
                $newarr = $o->get();
                $newarr['fechapedido'] = $o->getFechapedido();
                $newarr['direccion'] = $o->getDireccion()->get();
                $neworders[] = $newarr;
            }
            
            
            $user = $this->getSession()->getLogin()->getNombre();
            
            $this->getModel()->set('username',$user);
            $this->getModel()->set('tarjetas',$newcards);
            $this->getModel()->set('direcciones',$addresses);
            $this->getModel()->set('pedidos',$neworders);
            
        } else {
            //5º producir resultado
            $this->login();
            
        }
    }

    function register() {
        //1º control de sesión, si está logueado no se muestra el registro
        if(!$this->getSession()->isLogged()) {
            //5º producir resultado
            $this->getModel()->set('pagetitle', 'Sign up');
            $this->getModel()->set('twigFile', 'page-register.html');
        }
    }
    
    function login() {
        //1º control de sesión, si está logueado no se muestra el login
        if(!$this->getSession()->isLogged()) {
            //2º lectura de datos    -> no hay
            //3º validación de datos -> no hay
            //4º usar el modelo    -> no hace falta
            //5º producir resultado
            $redirect = Reader::read('redirect');
            if ($redirect == null || $redirect == '') {
                $redirect == App::BASE;
            }
            
            
            //$op = Reader::read('op');
            //$r = Reader::read('p');
            //alert = \framework\objects\Alert::$mensajes[$op][$r];
            //echo $alert;exit;
            
            $this->getModel()->set('pagetitle', 'Sign in');
            $this->getModel()->set('redirect',$redirect);
            $this->getModel()->set('twigFile', 'page-login.html');
        } else {
            header('Location: ' . $redirect);
            exit();
        }
    }
    
    
    
}