<?php

namespace framework\objects\dbobjects;

class Usuario {

    use \framework\classes\Common;

    private $id, $correo, $clave;

    function __construct($id = null, $correo = null, $clave = null) {
        $this->id = $id;
        $this->correo = $correo;
        $this->clave = $clave;
    }

    function getId() {
        return $this->id;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getClave() {
        return $this->clave;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

}