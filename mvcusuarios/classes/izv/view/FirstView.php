<?php

namespace izv\view;

use izv\model\Model;
use izv\tools\Util;

class FirstView extends View {

    function render($accion) {
        $this->getModel()->set('twigFolder', 'twigtemplates/bootstrap/');
        $datos = $this->getModel()->getViewData();
        require_once("classes/vendor/autoload.php");
        $loader = new \Twig_Loader_Filesystem($this->getModel()->get('twigFolder'));
        $twig = new \Twig_Environment($loader);
        return $twig->render($this->getModel()->get('twigFile'), $datos);
    }
}