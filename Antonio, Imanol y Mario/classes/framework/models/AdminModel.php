<?php

namespace framework\models;

use framework\objects\dbobjects\Usuario;
use framework\databases\Database;
use framework\databases\objmanagers\ManageUsuario;

class AdminModel extends UserModel {

    function getAllOrOne($id = null) {
        $manager = new ManageUsuario($this->getDatabase());
        return $manager->getAllOrOne($id);
        /*if($id === null) {
            return $manager->getAll();
        } else {
            return $manager->get($id);
        }*/
    }
}