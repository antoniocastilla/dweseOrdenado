<?php

namespace izv\view;

use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Alert;
use izv\tools\Tools;
use izv\tools\Util;

class CardsView extends View {

    function __construct(Model $model) {
        parent::__construct($model);
        $this->getModel()->set('twigFolder', 'twigtemplates/bookmarks');
    }

    function render($accion) {
        $data = $this->getModel()->getViewData();
        
        require_once 'classes/vendor/autoload.php';
        
        // Recojer datos (posible alert)
        $type = Reader::read('op');
        $r = Reader::read('r');
        
        if($type !== null && $r !== null) {
            $alert = Alert::getOnlyAlert($type, $r);
            $data['alert'] = $alert;
        }
        
        $loader = new \Twig_Loader_Filesystem($data['twigFolder']);
        $twig = new \Twig_Environment($loader);
        return $twig->render($data['twigFile'], $data);
    }
}