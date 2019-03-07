<?php

namespace izv\view;

use izv\model\Model;
use izv\tools\Util;

class AjaxView extends View {

    function render($accion) {
        $datos = $this->getModel()->getViewData();
        header('Content-type:application/json');
        return json_encode($datos);
    }
}