<?php

namespace izv\model;

use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageUsuario;

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
}