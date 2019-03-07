<?php

namespace izv\controller;

use izv\app\App;
use izv\data\Usuario;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Util;

class AjaxController extends Controller {
    
    private $idUser;
    private $usuario;


    function __construct(Model $model) {
        parent::__construct($model);
        if (!$this->getSession()->isLogged()) {
            header('Location: ' . App::BASE . 'user/dologout');
            exit();
        }
        $this->idUser = $this->getSession()->getLogin()->getId();
        $this->usuario = $this->getModel()->getUser($this->idUser);
        //...
    }
    
    function main() {
        $this->listalinks();
    }
    
    function listalinks() {
        
        $page = Reader::read('pagina');
        if (!is_numeric($page) || $page <= 0 ) {
            $page = 1;
        }
        
        //$r = $this->getModel()->getAllLinks($this->idUser);
        $r = $this->getModel()->getAllLinksPag($page);
        $totalPostsReturned = $r->getIterator()->count();
        $totalPosts = $r->count();
        
        $limit = 5;
        $maxPages = ceil( $totalPosts / $limit);
        $thisPage = $page;
        
        
        $cats = $this->getModel()->getAllCategories($this->idUser);
        $cats = $this->getNiceArray($cats);
        
        $links = [];
        
        foreach ($r as $link) {
            $individual = [];
            $individual['link'] = $link->get();
            $individual['categoriaid'] = null;
            if ( $link->getCategoria() !== null ) {
                $individual['categoriaid'] = $link->getCategoria()->getId();
                $individual['categoria'] = $link->getCategoria()->getNombre();
            }
            $links[] = $individual;
        }
        
        $this->getModel()->set('links', $links);
        $this->getModel()->set('categories', $cats);
        $this->getModel()->set('maxPages', $maxPages);
        $this->getModel()->set('thisPage', $thisPage);
    }
    
    function listacategories() {
        
        $cats = $this->getNiceArray($this->usuario->getCategorias());
        
        $this->getModel()->set('categories', $cats);
    }
    
    function comprobartitulo() {
        $titulo = Reader::read('titulo');
        $available = 0;
        if($titulo !== '') {
            $available = $this->getModel()->tituloAvailable($titulo);
        }
        $this->getModel()->set('titulodisponible', $available);
    }
    
    
    function edit() {
        $cancion = Reader::readObject("izv\data\Cancion");
        if($cancion->getTitulo() == '') {
            $resultado = 0;
        } else {
            $resultado = $this->getModel()->editCancion($cancion);
        }
        $this->getModel()->set('edit', $resultado);
    }
    
    function deleteSong() {
        $id = Reader::read('id');
        $resultado = 0;
        echo 'ID cancion: ' . $id;
        if ($id !== null && is_numeric($id)) {
            $resultado = $this->getModel()->remove($id);
        }
        $this->getModel()->set('delete', $resultado);
    }
    
    function register() {
        
        $link = Reader::readObject("izv\data\Link");
        $idCategory = Reader::read('newCategory');
        
        
        if($link->getTitle() == '') {
            $resultado = 0;
        } else {
            $category = $this->getModel()->getCategory($idCategory);
            
            $link->setCategoria($category);
            $link->setUsuario($this->usuario);
            $resultado = $this->getModel()->saveLink($link);
        }
        $this->getModel()->set('register', $resultado);
    }
    
    function addcategory() {
        
        $category = Reader::readObject('izv\data\Categoria');
        if ($category->getNombre() == '' ) {
            $resultado = 0;
        } else {
            $category->setUsuario($this->usuario);
            $resultado = $this->getModel()->addCategory($category);
        }
        $this->getModel()->set('addcategory', $resultado);
        
    }
    
    function deletecategory() {
        
        $id = Reader::read('id');
        if (is_numeric($id) && $id > 0) {
            $r = $this->getModel()->removeCategory($id);
        } else {
            $r = 0;
        }
        
        $this->getModel()->set('deletecategory', $r);
    }
    
    function deletelink() {
        
        $id = Reader::read('id');
        if (is_numeric($id) && $id > 0) {
            $r = $this->getModel()->removeLink($id);
        } else {
            $r = 0;
        }
        
        $this->getModel()->set('deletelink', $r);
    }
}   