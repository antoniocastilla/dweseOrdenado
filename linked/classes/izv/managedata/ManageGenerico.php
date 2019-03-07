<?php

namespace izv\managedata;

use \izv\data\Generico;
use \izv\database\Database;

class ManageGenerico {

    private $db;

    function __construct(Database $db) {
        $this->db = $db;
    }

    function add(Generico $objeto) {
        $resultado = 0;
        if($this->db->connect()) {
            
        }
        return $resultado;
    }

    function edit(Generico $objeto) {
        $resultado = 0;
        if($this->db->connect()) {
            
        }
        return $resultado;
    }
    
    function get($id) {
        $objeto = null;
        if($this->db->connect()) {
            
        }
        return $objeto;
    }

    function getAll() {
        $array = array();
        if($this->db->connect()) {
            
        }
        return $array;
    }

    function remove($id) {
        $resultado = 0;
        if($this->db->connect()) {
            
        }
        return $resultado;
    }
}