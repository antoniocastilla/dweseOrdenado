<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;

class DashboardController extends Controller {
    
    private $accionPorDefecto;

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('title','Dashboard');
        $this->accionPorDefecto = 'dashboard';
    }
    
    function __checkLogged() {
        if (!$this->getSession()->isLogged() || !$this->getSession()->getLogin()->getActivo()) {
            header('Location: user/dologout');
            exit();
        }
        $this->getModel()->set('user', $this->getSession()->getLogin()->getNombre());
    }
    
    function __invalidParameters() {
        $path = array();
        //if (isset($_SERVER['REQUEST_URI'])) {
        $request_path = explode('?', $_SERVER['REQUEST_URI']);
        if (isset($request_path[1])) {
            $vars = array_filter(explode('&', $request_path[1]));
            if (count($vars) > 0) {
                foreach ($vars as $var) {
                    //Si no contiene el = de los parámetros
                    if (!\strpos($var , '=') !== false) {
                        return true;
                    }
                    $t = explode('=', $var);
                    if (isset($t[1]) && $t[1] == '') {
                        return true;
                    }
                }
            }    
        }
        return false;
    }
    
    function go($base_redirect = null) {
        $path = array();
        //if (isset($_SERVER['REQUEST_URI'])) {
        $request_path = explode('?', $_SERVER['REQUEST_URI']);
        $vars = explode('&', $request_path[1]);
        
        $redirect = $this->accionPorDefecto;
        foreach ($vars as $var) {
            $t = explode('=', $var);
            if (isset($t[1]) && !$t[1] == '') {
                $path[$t[0]] = $t[1];
            }
        }
        if($base_redirect === null) {
            if (!isset($path['redirect'])) {
                header('Location: ' . App::BASE . $this->accionPorDefecto);
                exit();
            }
            $redirect = $path['redirect'];
            unset($path['redirect']);
        } else {
            $redirect = $base_redirect;
        }
        //echo $redirect;exit();
        //??????
        //$redirect = $path['redirect'];
        //unset($path['redirect']);
        $s = '';
        if (count($path) >= 1) {
            $s = '?';
            $i = 0;
            foreach($path as $key=> $value){   
                if($i < (count($path)-1)) {
                    $s .= $key . '=' . $path[$key] . '&';
                } else {
                    $s .= $key . '=' . $value;
                }
                $i++;
            }
        }
            
        //}
        //echo App::BASE . $redirect . $s;exit;
        header('Location: ' . App::BASE . $redirect . $s);
        exit();
    }

    function main() {
        $this->__checkLogged();
        //5º producir resultado
        //$users = $this->getModel()->getAllOrOne();
        $user = $this->getSession()->getLogin()->get();
        $this->getModel()->set('user', $user);
        $this->getModel()->set('twigFile', 'editSelf.twig');
        if ($this->getSession()->getLogin()->getAdmin()) {
            $this->getModel()->set('admin',true);
            $this->getModel()->set('twigFile', 'dashboard.twig');
        }
        
    }
    
    function dashboard() {
        main();
    }
    
    function user() {
        $this->__checkLogged();
        
        //5º producir resultado
        $user = $this->getSession()->getLogin()->get();
        $this->getModel()->set('user', $user);
        $this->getModel()->set('twigFile', 'editSelf.twig');
        if ($this->getSession()->getLogin()->getAdmin()) {
            $id = Reader::read('id');
            if(!($id == null || !is_numeric($id) || $id <= 0)) {
                $user = $this->getModel()->get($id);
                $this->getModel()->set('user', $user);
            }
            $this->getModel()->set('admin',true);
            $this->getModel()->set('twigFile', 'editRoot.twig');
        }
    }
    
    function table() {
        $this->__checkLogged();
        if($this->__invalidParameters()) {
            echo 'Hay malos parametros'; 
            $this->go('dashboard/table');
        }
        
        $usuarios = $this->getModel()->getAll();
        $this->getModel()->set('users', $usuarios);
        $this->getModel()->set('twigFile', 'tableBasic.twig');
        if ($this->getSession()->getLogin()->getAdmin()) {
            $ordenes = [
                'id' => 'id',
                'correo' => 'correo',
                'alias' => 'alias',
                'nombre' => 'nombre',
                'admin' => 'admin',
                'activo' => 'activo',
                'fechaalta' => 'fechaalta'
            ];
            $pagina = Reader::read('pagina');
            if($pagina === null || !is_numeric($pagina)) {
                $pagina = 1;
            }
            $orden = Reader::read('orden');
            if(!isset($ordenes[$orden])) {
                $orden = 'nombre';
            }
            $filtro = Reader::read('filtro');
            $r = $this->getModel()->getUsuarios($pagina, $orden, $filtro);
            //echo Util::varDump($r)
            $this->getModel()->add($r);
            $this->getModel()->set('admin',true);
            $this->getModel()->set('twigFile', 'tableRoot.twig');
        }
    }
    
    
}