<?php

namespace framework\view;

use izv\model\Model;
use izv\tools\Util;

class SecondView extends View {

    function render($accion) {
        $this->getModel()->set('twigFolder', 'twigtemplates/zeta');
        $datos = $this->getModel()->getViewData();
        $loader = new \Twig_Loader_Filesystem('twigtemplates/zeta/');
        $twig = new \Twig_Environment($loader);
        return $twig->render($this->getModel()->get('twigFile'), $datos);
    }
}