<?php

namespace framework\controllers;
use framework\app\App;
use framework\models\Model;
use framework\objects\Session;
use framework\objects\Reader;
use framework\objects\Carrito;
use framework\objects\Item;

class ContactStatic extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('twigFile', 'static-contact.html');
    }
    
    function defaultAction() {
            $pagetitle = 'Contact';
            
            $this->getModel()->set('pagetitle', $pagetitle);

    }
    
}