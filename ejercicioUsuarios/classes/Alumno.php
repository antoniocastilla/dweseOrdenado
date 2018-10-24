<?php

class Alumno {
    
    use Comun;
    
    function __construct($dni = null, $nombre = null, $apellidos = null, 
    $numeroMatricula = null, $fechaNacimiento =  null, $sexo = null, $telefono = null) {
        $this->apellidos = $apellidos;
        $this->dni = $dni;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nombre = $nombre;
        $this->numeroMatricula = $numeroMatricula;
        $this->sexo = $sexo;
        $this->telefono = $telefono;
    }
    
    function __toString() {
        return 'El alumno es: ' . $this->nombre;
    }

    private $numeroMatricula, $nombre, $apellidos, $fechaNacimiento,
            $telefono, $sexo, $dni;
            
    function getNumeroMatricula() {
        return $this->numeroMatricula;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getDni() {
        return $this->dni;
    }

    function setNumeroMatricula($numeroMatricula) {
        $this->numeroMatricula = $numeroMatricula;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }
    
    
}