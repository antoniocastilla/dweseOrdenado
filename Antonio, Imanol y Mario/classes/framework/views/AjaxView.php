<?php

namespace framework\views;

use framework\classes\CrossOrigin;

class AjaxView extends View {

    function render($accion) {
        header('Content-type:application/json');
        CrossOrigin::cors();

        $data = $this->getModel()->getViewData();
        /*$loader = new \Twig_Loader_Filesystem('templates/ajax');
        $twig = new \Twig_Environment($loader);
        return $twig->render('_ajax.html', $data);*/
        return json_encode($data);
    }
}