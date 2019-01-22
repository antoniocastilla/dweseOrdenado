<?php

namespace izv\managedata;

use \izv\data\City;
use \izv\database\Database;

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
                    $array[] = $objeto;
                }
            }
        }
        return $array;
    }

}