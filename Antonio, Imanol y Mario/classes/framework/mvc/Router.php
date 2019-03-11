<?php

namespace framework\mvc;

class Router {

    private $rutas, $ruta;
    
    function __construct($ruta) {
        $this->rutas = array(
            //Ruta de blog de wordpress no necesita MVC.
            //'blog' => new Route('Model', 'View', 'WordpressController'),
            
            
            //Landing - funciona bien y enruta.
            'index' => new Route('UserModel', 'FrontpageView', 'FrontpageController'),
            
            //Single-product.php y vista tienda.
            'product' => new Route('UserModel', 'ShoeView' , 'ShoeController'),
            'store' => new Route('UserModel', 'StoreView' , 'StoreController'),
            
            //Carrito y checkout
            'cart' => new Route('UserModel', 'CartView' , 'CartController'),
            'checkout' => new Route('UserModel', 'CheckoutView' , 'CheckoutController'),
            
            //Todo el panel de administracion (incluye para administrar usuarios, tarjetas)
            'admin' => new Route('AdminModel', 'AdminView' , 'AdminController'),
            
            'user' => new Route('UserModel', 'UserView' , 'UserController'),
            
            'ajax' => new Route('AdminModel', 'AjaxView', 'AjaxController'),
            //'old'   => new Route('FirstModel', 'FirstView' , 'FirstController'),
            //'zeta'  => new Route('FirstModel', 'SecondView', 'FirstController')
            
            
            
            //Static pages
            'about' => new Route('DataModel', 'StoreView', 'AboutStatic'),
            'contact' => new Route('DataModel', 'StoreView', 'ContactStatic'),
            'thankyou' => new Route('DataModel', 'StoreView', 'StoreThanks')
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