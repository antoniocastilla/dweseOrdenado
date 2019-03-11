<?php

namespace framework\databases\objmanagers;

use \framework\objects\dbobjects\City;
use \framework\databases\Database;

class ManageCity {

    private $db;

    function __construct(Database $db) {
        $this->db = $db;
    }

    function getAll() {
        $array = array();
        if($this->db->connect()) {
            $sql = 'select * from city order by id';
            if($this->db->execute($sql)) {
                while($fila = $this->db->getSentence()->fetch()) {
                    $objeto = new City();
                    $objeto->set($fila);
                    //$pais = new Country();
                    //$pais->set($fila, 6);
                    $array[] = $objeto;
                }
            }
        }
        return $array;
    }

}