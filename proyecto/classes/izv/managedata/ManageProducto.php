<?php

namespace izv\managedata;

use \izv\data\Producto;
use \izv\database\Database;

class ManageProducto {

    private $db;

    function __construct(Database $db) {
        $this->db = $db;
    }

    function add(Producto $producto) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'insert into producto values(null, :nombre, :precio, :observaciones)';
            $array = array(
                'nombre' => $producto->getNombre(), 
                'precio' => $producto->getPrecio(),
                'observaciones' => $producto->getObservaciones()
            );
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getConnection()->lastInsertId();
            }
        }
        return $resultado;
    }

    function edit(Producto $producto) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'update producto set nombre = :nombre, precio = :precio, observaciones = :observaciones where id = :id';
            if($this->db->execute($sql, $producto->get())) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }

    function get($id) {
        $producto = null;
        if($this->db->connect()) {
            $sql = 'select * from producto where id = :id';
            $array = array('id' => $id);
            if($this->db->execute($sql, $array)) {
                if($fila = $this->db->getSentence()->fetch()) {
                    $producto = new Producto();
                    $producto->set($fila);
                }
            }
        }
        return $producto;
    }

    function getAll() {
        $array = array();
        if($this->db->connect()) {
            $sql = 'select * from producto order by nombre';
            if($this->db->execute($sql)) {
                while($fila = $this->db->getSentence()->fetch()) {
                    $producto = new Producto();
                    $producto->set($fila);
                    $array[] = $producto;
                }
            }
        }
        return $array;
    }

    function remove($id) {
        $resultado = 0;
        if($this->db->connect()) {
            $sql = 'delete from producto where id = :id';
            $array = array('id' => $id);
            if($this->db->execute($sql, $array)) {
                $resultado = $this->db->getSentence()->rowCount();
            }
        }
        return $resultado;
    }
}