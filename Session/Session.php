<?php

class Session {
    
    private $name;
    
    function __construct($name = 'usuario') {
        $this->name = trim($name);
        if (isset($this->name)) {
            name_session($this->name);
            session_start();
        }
    }
    
    public function get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }
    
    public function set($name, $value) {
        $name = trim($name);
        $value = trim($value);
        if(session_status() !== PHP_SESSION_NONE && isset($name) && isset($value)) {
            $_SESSION[$name] = $value;
        }
        return $this;
    }
    
    public function destroy() {
        if (session_status() !== PHP_SESSION_NONE) {
            //Si el estado es diferente de ninguno
            session_destroy();
        }
    }
    
    public function getLogin($name) {
        if (session_status() !== PHP_SESSION_NONE && isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }
    
    function setLogin($user, $name='usuario') {
        $value = trim($user);
        if(session_status() !== PHP_SESSION_NONE && isset($name) && isset($value)) {
            session_regenerate_id();
            $_SESSION[$name] = $value;
        }
        return $this;
    }
    
    function logout($name='usuario') {
        if (session_status() !== PHP_SESSION_NONE) {
            unset($_SESSION[$name]);
        }
    }
}
