<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;

class DashboardController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('title','Dashboard');
        $this->getModel()->set('user', $this->getSession()->getLogin()->getNombre());
    }
    
    function __checkLogged() {
        if (!$this->getSession()->isLogged() || !$this->getSession()->getLogin()->getActivo()) {
            header('Location: index/main');
            exit();
        }
    }

    function main() {
        $this->__checkLogged();
        //5º producir resultado
        //$users = $this->getModel()->getAllOrOne();
        $user = $this->getSession()->getLogin()->get();
        $this->getModel()->set('user', $user);
        $this->getModel()->set('twigFile', 'user.twig');
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
        //$users = $this->getModel()->getAllOrOne();
        //echo Util::varDump($this->getSession()->getLogin()->get());exit();
        if ($this->getSession()->getLogin()->getAdmin()) {
            $this->getModel()->set('admin',true);
        }
        $user = $this->getSession()->getLogin()->get();
        $this->getModel()->set('user', $user);
        $this->getModel()->set('twigFile', 'editSelf.twig');
    }
    
    function table() {
        $this->__checkLogged();
        $this->getModel()->set('twigFile', 'table.twig');
        if ($this->getSession()->getLogin()->getAdmin()) {
            $this->getModel()->set('admin',true);
            $this->getModel()->set('twigFile', 'tableRoot.twig');
        }
    }
    
    
}