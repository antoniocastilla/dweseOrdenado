<?php

namespace framework\controllers;

use framework\app\App;
use framework\models\Model;
use framework\objects\Session;
use framework\objects\Reader;
use framework\classes\Util;
use framework\classes\Mail;
use framework\dbobjects\Pedido;
use framework\dbobjects\Detalle;
use framework\dbobjects\Direccion;

class CheckoutController extends Controller {

    function __construct(Model $model) {
        parent::__construct($model);
        //$this->getModel()->set('urlbase', App::BASE);
        $this->getModel()->set('pagetitle', 'Checkout');
        $this->getModel()->set('twigFile', 'page-checkout.html');
    }
    
    function defaultAction() {
        //$this->__checkLogged('user/login?redirect=checkout');
        if (!$this->getSession()->isLogged()) {
            $thisurl='checkout';
            header('Location:' . App::BASE . 'user/login?redirect='.$thisurl);
            exit();
        } else {
            $pagetitle = 'Cart';
            
            $theuser = $this->getSession()->getLogin();
            
            //Datos del usuario
            $this->getModel()->set('user',$theuser);
            
            //Direcciones
            $dirs = $this->getModel()->getSingleUserAddress($theuser->getId());
            
            if ($dirs == null || sizeof($dirs) == 0 || count($dirs) <= 0) {
                $hasdirs = false;
            } else {
                $hasdirs = true;
            }
            $this->getModel()->set('hasdirecciones', $hasdirs);
            $this->getModel()->set('direcciones',$dirs);
            
            //Metodos de pago
            $pays = $this->getModel()->getSingleUserCards($theuser->getId());
            
            if ($pays == null || sizeof($pays) <= 0 || count($pays) <= 0) {
                $haspays = false;
            } else {
                $haspays = true;
            }
            $this->getModel()->set('haspayment',$haspays);
            $this->getModel()->set('payment',$pays);
            
            //El carrito
            $fullcart = $this->getSession()->getCart();
            $hasitems = !$this->getSession()->getCart()->isEmpty();
            
            $this->getModel()->set('hasitems', $hasitems);
            $this->getModel()->set('items',$fullcart);
        }
    }
    
    
    
    
    function docheckout(){
        
        //A la berga si no hay permisos
        if (!$this->getSession()->isLogged()) {
            header('Location:' . App::BASE . 'user/login');
            exit();
        }
        //Usuario del pago PARA GUARDAR
        $idusuario = $this->getSession()->getIDUsuario();
        $userobj = $this->getModel()->getUsuario($idusuario);
        //$userobj->setFechaalta($userobj->getFechaalta());
        /*echo '-------------------------------------------------------- <br>';
        echo '<pre>' . \Doctrine\Common\Util\Debug::dump($userobj) . '</pre>';
        exit();*/

        //Get the variables del metodo post
        $f_nombre=Reader::read('checkoutnombre');
        $f_apellidos=Reader::read('checkoutapellidos');
        $f_calle=Reader::read('checkoutaddress');
        $f_ciudad=Reader::read('checkoutcity');
        $f_cp=Reader::read('checkoutpostcode');
        $f_provincia=Reader::read('checkoutstate');
        $f_pais=Reader::read('checkoutcountry');
        
        $f_email=Reader::read('checkoutemail');
        //$f_cupon=Reader::read('cupon');
        $f_tarjeta=Reader::read('checkoutcard');
        
        //Verificarlas
        $bool_name = isset($f_nombre);
        $bool_apel = isset($f_apellidos);
        $bool_calle = isset($f_calle);
        $bool_ciudad = isset($f_ciudad);
        $bool_cp = isset($f_cp);
        $bool_provincia = isset($f_provincia);
        $bool_pais = $this->ckVerifyCountry($f_pais);
        
        $bool_email = $this->ckVerifyEmail($f_email);
        $bool_tarjeta = $this->ckVerifyCardId($f_tarjeta);
        
        
        //Muro de trump <- xdd
        /* _                               
         | |                              
         | |_ _ __ _   _ _ __ ___  _ __   
         | __| '__| | | | '_ ` _ \| '_ \  
         | |_| |  | |_| | | | | | | |_) | 
          \__|_|   \__,_|_| |_| |_| .__/  
         | |                      | |     
         | |_ _____      _____ _ _|_|     
         | __/ _ \ \ /\ / / _ | '__|      
         | || (_) \ V  V |  __| |         
          \__\___/ \_/\_/ \___|_|
        */
        if ($bool_name &&
        $bool_apel &&
        $bool_calle &&
        $bool_ciudad &&
        $bool_cp &&
        $bool_provincia &&
        $bool_pais &&
        $bool_email &&
        $bool_tarjeta)
        {
            
            echo var_dump('MURO DE TRUMP');
                
            //Coger los datos originales de la BBDD
            $payCard = $this->getModel()->getCardFromIdUser($f_tarjeta, $idusuario);
            $finddirect = $this->getModel()->findAddressFromAll($f_calle, $f_ciudad, $f_cp, $f_provincia, $f_pais, $idusuario);
            
            
            echo var_dump('Gotten all');
            /*echo '---------------------comienza direct----------------------------------- <br>';
            echo '<pre>' . \Doctrine\Common\Util\Debug::dump($direct) . '</pre>';
            echo '---------------------finaliza direct----------------------------------- <br>';
            echo '---------------------comienza paycard----------------------------------- <br>';
            echo '<pre>' . \Doctrine\Common\Util\Debug::dump($payCard) . '</pre>';
            echo '---------------------finaliza direct----------------------------------- <br>';
            exit();*/
            if ($finddirect == 'Sin direccion') {
                echo var_dump('Sin direccion faileo antes de newDireccion');
                $direct = new Direccion();
                echo var_dump('Sin direccion faileo antes de userobj');
                $direct->setDestinatario($userobj);
                echo var_dump('Sin direccion faileo');
                $direct->setPais($f_pais);
                $direct->setCiudad($f_ciudad);
                $direct->setCpostal($f_cp);
                $direct->setProvincia($f_provincia);
                $direct->setCalle($f_calle);
                $direct->setActivo(1);
                $this->getModel()->addSingleObject($direct);
                
            } else if ($finddirect == 'Direccion no activa') {
                $direct = $this->getModel()->activeAddressFromAll($f_calle, $f_ciudad, $f_cp, $f_provincia, $f_pais, $idusuario);
                echo var_dump('Dir no activa antes');
                
                $this->getModel()->addSingleObject($direct);
                echo var_dump('Dir no activa desp');
            } else if($finddirect == 'Tiene direccion') {
                $direct = $this->getModel()->getAddressFromAll($f_calle, $f_ciudad, $f_cp, $f_provincia, $f_pais, $idusuario);
                echo var_dump('Tiene direcc');
            }
            
            echo var_dump('Tarjeta + User');
        
            //Coger el carrito ()
            $fullcart = $this->getSession()->getCart();    
            
            echo var_dump('got carrito');
            
            //Crear pedidito
            $PED = new Pedido();
            $PED->setUsuario($userobj);
            $PED->setMetodopago($payCard);
            $PED->setDireccion($direct);

            /*A la mierda* /
            $PED->setCupon(null);*/
            echo 'pre a la m...<br>';
            $this->getModel()->addSingleObject($PED);
            echo var_dump('Pedido');
            
            //Meter items del carrito en detalle
            $arrdep = [];
            foreach ($fullcart as $key => $item) {
                
                $DEP = new Detalle(); //$singleItem=[];
                
                $theshoe=$this->getModel()->getSingleShoe($item->getId());
                $DEP->setZapato($theshoe);
                $DEP->setCantidad($item->getCantidad());
                $DEP->setPpu($item->getPrecio());
                
                $cant = $item->getCantidad();
                $ppu = $item->getPrecio();
                $mulprice = $cant * $ppu;
                $DEP->setTotal($mulprice);
                
                $DEP->setPedido($PED);
                
                $arrdep[] = $DEP;
                
                echo var_dump('Item '.$key);
                
                
                //restar a talla
                $tallarest = $item->getTalla();
                //$tallarest->setStock($tallarest->getStock-$cant);
                $arrtallas = $theshoe->getTallas();
                
                foreach ($arrtallas as $key => $a) {
                    if ($a === $tallarest) {
                        $theshoe->getTallas()[$key]->setStock(($theshoe->getTallas()[$key]->getStock() - 1));
                    }
                }
                
                $this->getModel()->addSingleObject($theshoe);
                
                
            }
            
            //Suma de las cantidades de cada producto
            $totalprod = 0;
            foreach ($fullcart as $item) {
                $totalprod += $item->getCantidad();
            }
            
            echo var_dump('Sum cantidades');
            
            //Primero guardar el pedido
            $this->getModel()->addSingleObject($PED);
            
            echo var_dump('Guardo object pedido');
            
            //Depué guardar los detalles
            foreach ($arrdep as $d) {
                $this->getModel()->addSingleObject($d);
            }
            
            echo var_dump('Guardo detalles');
            
            //Mandar correo al mail
            //Mail::sendOrderMessage($mailstring, $userobj);
            
            //Limpiar carrito
            $this->getSession()->delCart();
            
            header('Location: ' . App::BASE . 'thankyou');
            exit();
                
        } else {
            header('Location:' . App::BASE . 'cart');
            exit();
        }
        
    }
    
    function ckVerifyCountry($cstr){
        $original = $cstr;
        $caps = strtoupper($cstr);
        
        if (strlen($cstr) == 2 && $original == $caps) {
            
            return true;
        } else {
            echo var_dump('varifyCountry fail');
            return false;
        }
        
    }
    
    function ckVerifyEmail($mailstr){
        if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $mailstr)){
            echo var_dump('varifyEmail fail');
            return false;
        }else{
            return true;
        }
    }
    
    function ckVerifyCardId($cid){
        if ($cid == null || !is_numeric($cid)) {
            
            echo var_dump('varifyCard fail');
            
            return false;
        } else {
            return true;
        }
        
    }
}