<?php

namespace izv\mvc;

class Router {

    private $rutas, $ruta;
    
    function __construct($ruta) {
        $this->rutas = array(
            'dashboard' => new Route('DashboardModel', 'DashboardView' , 'DashboardController'),
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