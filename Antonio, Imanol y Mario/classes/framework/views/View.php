<?php

namespace framework\views;

use framework\models\Model;
use framework\classes\Util;

class View {

    private $model;

    function __construct(Model $model) {
        $this->model = $model;
    }
    
    function getModel() {
        return $this->model;
    }

    function render($accion) {
        $datos = $this->getModel()->getViewData();
    }
}