<?php

namespace izv\model;

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;
use izv\tools\Pagination;

class DashboardModel extends UserModel {

    function getAllOrOne($id = null) {
        $manager = new ManageUsuario($this->getDatabase());
        return $manager->getAllOrOne($id);
        /*if($id === null) {
            return $manager->getAll();
        } else {
            return $manager->get($id);
        }*/
    }
    
    function getAll() {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $usuarios = $manager->getAll();
        $db->close();
        return $usuarios;
        
    }
    
    function get($id) {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $usuario = $manager->get($id);
        $db->close();
        return $usuario;
    }
    
    function getTotalUsuarios() {
        $usuarios = 0;
        if($this->getDatabase()->connect()) {
            $sql = 'select count(*) from usuario2';
            if($this->getDatabase()->execute($sql)) {
                if($fila = $this->getDatabase()->getSentence()->fetch()) {
                    $usuarios = $fila[0];
                }
            }
        }
        $this->__destruct();
        return $usuarios;
    }
    
    function getUsuarios($pagina = 1, $orden = 'nombre', $filtro = null) {
        $total = $this->getTotalUsuarios();
        $paginacion = new Pagination($total, $pagina);
        $offset = $paginacion->offset();
        $rpp = $paginacion->rpp();
        $parametros = array(
            'offset' => array($offset, \PDO::PARAM_INT),
            'rpp' => array($rpp, \PDO::PARAM_INT)
        );
        if($filtro == null) {
            $sql = 'select * from usuario2 order by '. $orden .', nombre, correo, alias, fechaalta, id limit :offset, :rpp';
        } else {
            $sql = 'select * from usuario2
                    where id like :filtro or nombre like :filtro or correo like :filtro or alias like :filtro or fechaalta like :filtro
                    order by '. $orden .', nombre, correo, alias, fechaalta, id limit :offset, :rpp';
            $parametros['filtro'] = '%' . $filtro . '%';
        }
        $array = [];
        if($this->getDatabase()->connect()) {
            if($this->getDatabase()->execute($sql, $parametros)) {
                while($fila = $this->getDatabase()->getSentence()->fetch()) {
                    $objeto = new Usuario();
                    $objeto->set($fila);
                    $array[] = $objeto;
                }
            }
        }
        $enlaces = $paginacion->values();
        return array(
            'paginas' => $enlaces,
            'users' => $array,
            'rango' => $paginacion->range(2),
            'orden' => $orden,
            'filtro' => $filtro
        );
    }
}