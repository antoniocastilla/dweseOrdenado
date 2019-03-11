<?php

namespace framework\objects;

class Item {
    
    //use Comun;
    
    private $id, $nombre, $talla, $foto, $cantidad, $precio;
    
    function __construct($id, $nombre, $talla, $foto ,$precio, $cantidad = 1) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->talla = $talla;
        $this->foto = $foto;
        $this->precio = $precio;
        $this->cantidad = $cantidad;
    }
    
    function getId() {
        return $this->id;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function getTalla() {
        return $this->talla;
    }

    function getNombre() {
        return $this->nombre;
    }
    
    function getFoto() {
        return $this->foto;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
        return $this;
    }

    function setTalla($talla) {
        $this->talla = $talla;
        return $this;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }
    
    function setFoto($foto) {
        $this->foto = $foto;
        return $this;
    }


    function setPrecio($precio) {
        $this->precio = $precio;
        return $this;
    }
}