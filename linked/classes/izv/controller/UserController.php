<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;
use izv\tools\Mail;

class UserController extends Controller {

    /*
    Proceso general:
    1º Control de sesión
    2º Lectura de datos
    3º Validación de datos
    4º Usar el modelo
    5º Producir resultado (para la vista)
    */
    
    private $redirect;
    
    function __construct(Model $model) {
        parent::__construct($model);
        //...
    }
    
    function __checkAdmin() {
        if (!$this->getSession()->getLogin()->getAdmin()) {
            header('Location: index/main');
            exit();
        }
    }
    
    function __checkLogged() {
        if (!$this->getSession()->isLogged() || !$this->getSession()->getLogin()->getActivo()) {
            header('Location: index/main');
            exit();
        }
    }
    
    function __checkRedirect() {
        $this->redirect = Reader::read('redirect');
        if(!isset($redirect)) {
            $redirect = 'main';
        }
    }

    private function isAdministrator() {
        return $this->getSession()->isLogged() && $this->getSession()->getLogin()->getCorreo() === 'admin@admin.es';
    }

    function edituserbasic() {
        $this->__checkLogged();
        $this->__checkRedirect();
        $id = Reader::read('id');
        if($id == null || !is_numeric($id) || $id <= 0) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        $usuario = $this->getModel()->getUsuario($id);
        if($usuario == null) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        $changemail = false;
        foreach($usuario->get() as $i => $valor) {
            $campo = Reader::read($i);
            if ($campo !== null) {
                //echo '<br> He leido: ' . $i . ' con valor: ' . Reader::read($i);
                if ($i == 'correo') {
                    if ($campo !== $usuario->getCorreo()) {
                        $changemail = true;
                        $metodo = 'set' . ucfirst($i);
                        $usuario->$metodo($campo);
                    }
                } else {
                    $metodo = 'set' . ucfirst($i);
                    $usuario->$metodo($campo);
                }
            }
        }
        //echo Util::varDump($usuario);exit();
        $usuario->setClave('');
        $op = 'edituser';
        if ($changemail) {
            $usuario->setActivo(0);
            Mail::sendActivation($usuario);
            $op = 'editcorreo';
        }
        $resultado = $this->getModel()->editUsuario($usuario);
        
        // Sobreescribimos la sesión si hemos hecho cambios en nuestra cuenta.
        if($resultado && $usuario->getId() ===  $this->getSession()->getLogin()->getId()) {
            $this->getSession()->login($usuario);
        }
        $url = App::BASE . $this->redirect . '?op='. $op . '&r=' . $resultado;
        header('Location: ' . $url);
    }
    
    function edituseradvanced() {
        $this->__checkLogged();
        $this->__checkRedirect();
        $id = Reader::read('id');
        if($id == null || !is_numeric($id) || $id <= 0) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        $usuario = $this->getModel()->getUsuario($id);
        if($usuario == null) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        
        $op = 'edituser';
        $changepassword = false;
        $baja = false;
        
        $clavesDiferentes = false;
        $clave = Reader::read('clave');
        $claveNueva = '';
        if ( $clave != null) {
            $op = 'editclave';
            $claveCorrecta = Util::verificarClave($clave, $usuario->getClave());
            if ($claveCorrecta) {
                if ($clave !== Reader::read('clave1') & Reader::read('clave1') === Reader::read('clave2')) {
                    $clavesDiferentes = true;
                    $changepassword = true;    
                    $usuario->setClave(Reader::read('clave1'));
                }
            }
        } else {
            $option = Reader::read('baja');
            if (isset($option)) {
                $baja = true;
            }
        }
        $resultado = 0;
        $url = App::BASE . $this->redirect . '?op='. $op . '&r=' . $resultado;
        if($changepassword && $clavesDiferentes) {
            $usuario->setClave(Util::encriptar($usuario->getClave()));
            $resultado = $this->getModel()->editWithPassword($usuario);
            // Sobreescribimos la sesión si hemos hecho cambios en nuestra cuenta.
            if($resultado && $usuario->getId() ===  $this->getSession()->getLogin()->getId()) {
                $this->getSession()->login($usuario);
            }
        } else {
            $op = 'removeaccount';
            if ($option === 'option1') {
                $usuario->setActivo(0);
                $resultado = $this->getModel()->editUsuario($usuario);
            } else {
                if ($option === 'option2') {
                    $resultado = $this->getModel()->remove($usuario->getId());
                }
            }
            if ($resultado) {
                $this->dologout();
            }
        }
        header('Location: ' . $url);
    }
    
    function edituseradvancedp() {
        $this->__checkLogged();
        $this->__checkAdmin();
        $this->__checkRedirect();
        $id = Reader::read('id');
        if($id == null || !is_numeric($id) || $id <= 0) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        $usuario = $this->getModel()->getUsuario($id);
        if($usuario == null) {
            header('Location: ' . App::BASE . $redirect);
            exit();
        }
        $op = 'edituser';
        $changepassword = false;
        $clave = Reader::read('clave');
        if ($clave !== '') {
            $changepassword = true;
            $usuario->setClave($clave);
        } 
        
        $resultado = 0;
        if($changepassword) {
            $usuario->setClave(Util::encriptar($usuario->getClave()));
            $resultado = $this->getModel()->editWithPassword($usuario);
        }
        $url = App::BASE . $this->redirect . '?op='. $op . '&r=' . $resultado;
        header('Location: ' . $url);
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
        
        if($this->getSession()->isLogged()) {
            header('Location: ' . App::BASE . 'index?op=register&r=session');
            exit();
        }

        $usuario = Reader::readObject('izv\data\Usuario');
        $clave2 = Reader::read('clave2');

        if($usuario->getClave() !== $clave2 ||
            mb_strlen($usuario->getClave()) < 3) {
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
        if($r > 0) {
            $r = 1;
        }

        //5º producir resultado -> redirección
        header('Location: ' . App::BASE . 'index?op=register&r=' . $r);
        exit();
    }

    function login() {
        //1º control de sesión, si está logueado no se muestra el login
        if($this->getSession()->isLogged()) {
            header('Location: ' . App::BASE . 'index');
            exit();
        }
        $this->getModel()->set('title', 'Login');
        //2º lectura de datos    -> no hay
        //3º validación de datos -> no hay
        //4º usar el modelo    -> no hace falta
        //5º producir resultado
        $this->getModel()->set('twigFile', 'login.twig');
    }

    function main() {
        header('Location: ' . App::BASE . 'index');
        exit();
    }

    function register() {
        //1º control de sesión, si está logueado no se muestra el registro
        if($this->getSession()->isLogged()) {
            header('Location: ' . App::BASE . 'index');
            exit();
        }
        //5º producir resultado
        $this->getModel()->set('title', 'Register');
        $this->getModel()->set('twigFile', 'register.twig');
    }
    
}