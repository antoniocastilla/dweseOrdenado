<?php

namespace izv\view;

use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Tools;
use izv\tools\Util;

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
        return Util::varDump($datos);
    }
}