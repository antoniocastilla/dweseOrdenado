<?php

class Punto{
    
    use Comun;
    
    private $x, $y;
    
    function __construct($x = 0, $y = 0){
        
        $this->x = $x;
        $this->y = $y;
        
    }
    
    function __toString(){
        return '(' . $this->x . ',' . $this-> y . ')';
    }
    
    function getX(){
        return $this>x;
    }
    
    function setX($x){
        $this->x = $x;
        return $this;
    }
    
    function getY(){
        return $this>y;
    }
    
    function setY($y){
        $this->y = $y;
        return $this;
    }
    
    
}