<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Session;

class StoreController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('urlbase', App::BASE);
        $this->getModel()->set('pagetitle', '8Beast | Store');
        $this->getModel()->set('twigFile', 'page-store.html');
    }
    
    function defaultAction() {
        
        //Get publics/destinatarios
        $dest = $this->getModel()->getAllDestinatarios();
        
        //Get categories
        $cats = $this->getModel()->getAllCategories();
        
        //Size+Price no need
        
        //Get brands ????
        
        
        $this->getModel()->set('categories',$cats);
        $this->getModel()->set('dest',$dest);

    }
    
}