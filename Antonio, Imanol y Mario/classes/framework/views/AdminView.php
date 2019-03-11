<?php

namespace framework\views;

use framework\models\Model;
use framework\classes\Util;

class AdminView extends View {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('twigFolder', 'admin_html2/');
        $this->getModel()->set('twigFile', 'dashboard.twig');
    }

    function render($accion) {
        $data = $this->getModel()->getViewData();
        $loader = new \Twig_Loader_Filesystem($data['twigFolder']);
        $twig = new \Twig_Environment($loader);
        return $twig->render($data['twigFile'], $data);
    }
}