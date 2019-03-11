<?php

namespace framework\models;

use framework\databases\Database;
use framework\databases\DoctrineDB;

class Model {

    private $db;
    private $datosVista;
    
    //private $docdb;


    function __construct() {
        //$this->db = new Database(); //Deprecated¿
        
        $this->datosVista = array();
        $this->doc = new DoctrineDB();
        $this->db = $this->doc->getEntityManager();
        
        //$this->entityManager = $this->docdb->getEntityManager();
        //$this->docdb = DoctrineDB::getEntityManager();
        
    }
    
    function __destruct() {
        //$this->db->close();
    }
    
    function add(array $array) {
        foreach($array as $indice => $valor) {
            $this->set($indice, $valor);
        }
    }

    function get($name) {
        if(isset($this->datosVista[$name])) {
            return $this->datosVista[$name];
        }
        return null;
    }

    function getDatabase() {
        return $this->db;
    }

    function getViewData() {
        return $this->datosVista;
    }

    function set($name, $value) {
        $this->datosVista[$name] = $value;
        return $this;
    }
    
    
}