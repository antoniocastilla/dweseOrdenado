<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;
use izv\common\Common;

class CardsController extends Controller {
    
    private $accionPorDefecto;

    function __construct(Model $model) {
        parent::__construct($model);
        $this->accionPorDefecto = 'main';
        if (!$this->getSession()->isLogged()) {
            header('Location: user/dologout');
            exit();
        }
    }
    
    function main() {
        
        $id = $this->getSession()->getLogin()->getId();
        $userinfo = $this->getModel()->getUser($id);
        
        //$links = $this->getModel()->getAllLinks($id);
        $links = $this->getModel()->getAllLinksPag();
        $totalPostsReturned = $links->getIterator()->count();
        $totalPosts = $links->count();
        
        $limit = 5;
        $maxPages = ceil( $totalPosts / $limit);
        $thisPage = 1;
        
        
        
        $categories = $this->getModel()->getAllCategories($id);
        $categories = $this->getNiceArray($categories);
        
        
        $this->getModel()->set('user', $userinfo);
        $this->getModel()->set('links', $links);
        $this->getModel()->set('categories', $categories);
        $this->getModel()->set('twigFile', 'base.twig');
        
        $this->getModel()->set('maxPages', $maxPages);
        $this->getModel()->set('thisPage', $thisPage);
        
    }
    
    function user() {
        
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
            //echo Util::varDump($r);exit;
            $this->getModel()->add($r);
            $this->getModel()->set('admin',true);
            $this->getModel()->set('twigFile', 'tableRoot.twig');
        }
    }
    
    
}