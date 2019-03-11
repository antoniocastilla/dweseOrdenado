<?php

namespace framework\objects;

use framework\objects\Carrito;

class Session {

    const USER = '__user';
    const CART = '__cart';

    //constructor
    function __construct($name = null) {
        if (session_status() === PHP_SESSION_NONE) {
            if ($name !== null) {
                session_name($name);
            }
            session_start();
        }
    }
    
    //get
    function get($name) {
        $v = null;
        if(isset($_SESSION[$name])) {
            $v = $_SESSION[$name];
        }
        return $v;
    }
    
    //set
    function set($name, $value) {
        $_SESSION[$name] = $value;
        return $this;
    }
    
    //destroy
    function destroy() {
        session_destroy();
    }
    
    //Cart
    
    function getCart() {
        return $this->get(self::CART);
    }
    
    function hasCart() {
        return $this->getCart() !== null;
    }
    
    function newCart(Carrito $cart) {
        return $this->set(self::CART, $cart);
    }
    
    function delCart() {
        unset($_SESSION[self::CART]);
        return $this;
    }
    
    function sumCart() {
        return $this->getCart()->countItems();
    }
    
    
    //Logins
    function isLogged() {
        return $this->getLogin() !== null;
    }
    
    function isRoot() {//Deprecated
        return $this->isAdministrator();
    }
    
    function isAdministrator() {
        return $this->getLogin()->getAdministrador() !== null;
    }
    
    function getLogin() {
        return $this->get(self::USER);
    }
    
    function login(\framework\dbobjects\Usuario $user) {
        session_regenerate_id(true);
        return $this->set(self::USER, $user);
    }
    
    //logout
    function logout() {
        unset($_SESSION[self::USER]);
        return $this;
    }
    
    function getIDUsuario() {
        return $this->get(self::USER)->getId();
    }
}