<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Session;
use framework\objects\Reader;
use framework\objects\Carrito;
use framework\objects\Item;

class ShoeController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('urlbase', App::BASE);
        $this->getModel()->set('twigFile', 'page-product.html');
    }
    
    function defaultAction() {
        
        $requestedid = Reader::read('pid');
        if (!isset($requestedid) || !is_numeric($requestedid)) {
            header('Location: ' . App::BASE . 'index');
            exit();
        }

        //Thisproduct es un array.
        $thisproduct = $this->getModel()->getSingleShoe($requestedid);
        //if ($thisproduct == null) {
        //    header('Location: ' . App::BASE . 'store');
        //    exit();
        //}
        $thisproduct=$thisproduct->get();
        
        $pagetitle = 'Product | '.$thisproduct['marca']. ' ' .$thisproduct['modelo'];
        $this->getModel()->set('pagetitle', $pagetitle);
        $this->getModel()->set('product', $thisproduct);
        
        
        $stock = $this->getModel()->countStockShoe($requestedid);
        if ($stock[1] <= 0) {
            $this->getModel()->set('stock', false);
        } else {
            $this->getModel()->set('stock', true);
        }
        
    }

}