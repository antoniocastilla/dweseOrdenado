<?php

namespace izv\mvc;

class Router {

    private $rutas, $ruta;
    
    function __construct($ruta) {
        $this->rutas = array(
            'ajax' => new Route('CardsModel', 'AjaxView' , 'AjaxController'),
            'cards' => new Route('CardsModel', 'CardsView', 'CardsController'),
            'index' => new Route('Model', 'MainView', 'MainController'),
            'user' => new Route('UserModel', 'UserView', 'UserController'),
            
            
            'old'   => new Route('FirstModel', 'FirstView' , 'FirstController'),
            'gaas' => new Route('FirstModel', 'SecondView', 'FirstController')
        );
        $this->ruta = $ruta;
    }

    function getRoute() {
        $ruta = $this->rutas['index'];
        if(isset($this->rutas[$this->ruta])) {
            $ruta = $this->rutas[$this->ruta];
        }
        return $ruta;
    }
}