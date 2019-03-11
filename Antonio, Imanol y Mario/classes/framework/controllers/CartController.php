<?php

namespace framework\controllers;
use framework\app\App;
use framework\models\Model;
use framework\objects\Session;
use framework\objects\Reader;
use framework\objects\Carrito;
use framework\objects\Item;

class CartController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('twigFile', 'page-cart.html');
    }
    
    function defaultAction() {
        
            //cart es un array de items(otro array).
            $fullcart = $this->getSession()->getCart();
            $pagetitle = 'Cart';
            
            $this->getModel()->set('pagetitle', $pagetitle);
            $this->getModel()->set('items',$fullcart);
    }
    
}