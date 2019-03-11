<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Session;

class FrontpageController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        //$this->getModel()->set('urlbase', App::BASE);
        $this->getModel()->set('twigFile', 'page-landing.html');
    }
    
    function defaultAction() {
        $this->getModel()->set('pagetitle', '8Beast | Home page');
    }
    
    function segundaaccion() {
        //No se usa
        $this->getModel()->set('titulo', 'Segunda Acción');
        $this->getModel()->set('twigFile', '_second.html');
    }
}