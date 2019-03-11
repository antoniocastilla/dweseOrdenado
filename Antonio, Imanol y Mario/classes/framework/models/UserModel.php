<?php

namespace framework\models;

use framework\objects\dbobjects\City;
use framework\dbobjects\Usuario;
use framework\databases\Database;
use framework\databases\objmanagers\ManageCity;
use framework\databases\objmanagers\ManageUsuario;
use framework\objects\Pagination;
use framework\classes\Util;

class UserModel extends DataModel {

    function getaccount($correo, $clave) {
        $gestor = $this->getDatabase();
        $usuario = $gestor->getRepository('framework\dbobjects\Usuario')->findOneBy(array('correo' => $correo));
        if($usuario !== null) {
            $resultado = \framework\classes\Util::verificarClave($clave, $usuario->getClave());
            
            if($resultado) {
                $usuario->setClave('');
                //Alejandro dixit
                //$this->set('usuario', $usuario->get());
                return $usuario;
            }
        }
        return false;
    }

    function addUser(Usuario $usuario) {
        $id;
        
        try {
            $gestor = $this->getDatabase();
            $gestor->persist($usuario);
            $gestor->flush();
            $id = $usuario->getId();
        } catch(\Exception $e) {
            $id = 0;
        }
        
        return $id;
    }
    
    function login($user, $passwd) {
        $gestor = $this->getDatabase();
        
        // Buscamos primero por correo
        $usuario = $gestor->getRepository('framework\dbobjects\Usuario')->findOneBy(array('correo' => $user)); 
        if(!isset($usuario)) {
            $usuario = $gestor->getRepository('framework\dbobjects\Usuario')->findOneBy(array('nickname' => $user)); 
        }
        
        if(isset($usuario) && $usuario->getActivo() && Util::verificarClave($passwd, $usuario->getClave())) {
            return $usuario;
        }
        return false;
    }
    
    function activar($code, $id) {
        $entityManager = $this->getDatabase();
        $resultado = 0;
        if($id !== null && $code !== null) {
        
            $usuario = $entityManager->getRepository('framework\dbobjects\Usuario')
                        ->findOneBy(array('id' => $id));
            }
            //Util::varDump($usuario);
            if($usuario !== null && !$usuario->getActivo()) {
                $usuario->setActivo(1);
                $resultado = 1;
                $entityManager->flush();
            }
        return $resultado;
    }
    
}