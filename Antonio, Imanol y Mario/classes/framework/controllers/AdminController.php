<?php

namespace framework\controllers;

use framework\app\App;
use framework\dbobjects\Usuario;
use framework\models\Model;
use framework\objects\Reader;
use framework\objects\Session;
use framework\classes\Util;

class AdminController extends Controller {
    
    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('urlbase', App::BASE);
        $this->__checkAdmin();
    }
    
    
    function viewproducts() {
        $this->__checkAdmin();
        //$this->getModel()->addDestinatario();
        //$this->getModel()->saveSingleShoe();
        
        $products = $this->getModel()->getAllShoes();
        
        // Estructura que ha de seguir la creación de alertas
        // Para renderizarlas en twig
        /*
        $alerts = [];
        $alert = array (
            'class' => 'alert-success',
            'title' => 'Success',
            'message' => 'Se ha actualizado la información del zapato'
        );
        $alerts[] = $alert;*/
        
        // Recopilación de Categorias y Destinatarios
        $categories = $this->getModel()->getAllCategories();
        $publics = $this->getModel()->getAllDestinatarios();
        
        $this->getModel()->set('categories', $categories);
        $this->getModel()->set('publics', $publics);
        //$this->getModel()->set('alerts', $alerts);
        $this->getModel()->set('listshoes', $products);
        $this->getModel()->set('pagetitle', 'List Shoes');
        $this->getModel()->set('twigFile', 'table_shoe.twig');
        
        //echo '<pre>' . var_dump($products[0]->get()['destinatario']) . '</pre>';
        //echo '<pre>' . var_dump($products[0]->getDestinatario()) . '</pre>';
    }
    
    //Renderizar las tablas
    function viewusers() {
        $this->__checkAdmin();
        $users = $this->getModel()->getAllUsers();
        // Deleting passwords
        foreach ( $users as $user ) {
            $user->setClave('');
        }
        
        // Estructura que ha de seguir la creación de alertas
        // Para renderizarlas en twig
        /*
        $alerts = [];
        $alert = array (
            'class' => 'alert-success',
            'title' => 'Success',
            'message' => 'Se ha actualizado la información del usuario'
        );
        $alerts[] = $alert;*/
        
        // Recopilación de Categorias y Destinatarios
        //$categories = $this->getModel()->getAllCategories();
        //
        //$publics = $this->getModel()->getAllDestinatarios();
        
        //$this->getModel()->set('alerts', $alerts);
        $this->getModel()->set('listusers', $users);
        $this->getModel()->set('pagetitle', 'List Users');
        $this->getModel()->set('twigFile', 'table_user.twig');
    }
    
    function viewphotos() { // DEPRECATED
        $this->__checkAdmin();
        $queriedphoto = Reader::read('idshoe');
        
        if ($queriedphoto == null) {
            $photos = $this->getModel()->getAllPhotos();
        } else {
            $photos = $this->getModel()->getPhotosOfShoe($queriedphoto);
        }

        $arrphotos = [];
        foreach ($photos as $p) {
            $newphoto = [];
            $newphoto = $p->get();
            if($p->getZapato() != null) {
                $newphoto['zapato'] = $p->getZapato()->getId();
            }
            
            $arrphotos[] = $newphoto;
        }
        $this->getModel()->set('listphotos', $arrphotos);
        $this->getModel()->set('twigFile', 'table_photos.twig');
    }
    
    
    
    
    
    function viewpublic() {
        $this->__checkAdmin();
        $arr = $this->getModel()->getAllDestinatarios();
        
        
        $this->getModel()->set('list', $arr);
        $this->getModel()->set('twigFile', 'table_public.html');
        echo var_dump($arr[0]);
    }
    
    function viewcategories() {
        $this->__checkAdmin();
        $arr = $this->getModel()->getAllCategories();
        
        
        $this->getModel()->set('list', $arr);
        
        $this->getModel()->set('twigFile', 'table_categories.html');
        echo var_dump($arr[0]);
    }
    
    function defaultAction() {
        $this->__checkAdmin();
        $data = $this->getModel()->getDashboardData();
        
        $this->getModel()->set('pagetitle', 'Dashboard');
        $this->getModel()->set('data', $data);
    }
    
    function edit() {
        $this->__checkAdmin();
        
    }
    
    function doedit() {
        $this->__checkAdmin();
    }
}