<?php

namespace framework\views;

use framework\models\Model;
use framework\classes\Util;

class CartView extends View {

    function render($accion) {
        $this->getModel()->set('twigFolder', 'public_html/');
        $datos = $this->getModel()->getViewData();
        $loader = new \Twig_Loader_Filesystem($this->getModel()->get('twigFolder'));
        $twig = new \Twig_Environment($loader);
        
        return $twig->render($this->getModel()->get('twigFile'), $datos);
    }
}