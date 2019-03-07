<?php

namespace izv\model;

use izv\data\City;
use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageCity;
use izv\managedata\ManageUsuario;
use izv\tools\Pagination;
use izv\tools\Util;

class UserModel extends Model {

    function getCiudades($pagina = 1, $orden = 'name', $filtro = null) {
        $total = $this->getTotalCiudades();
        $paginacion = new Pagination($total, $pagina);
        $offset = $paginacion->offset();
        $rpp = $paginacion->rpp();
        $parametros = array(
            'offset' => array($offset, \PDO::PARAM_INT),
            'rpp' => array($rpp, \PDO::PARAM_INT)
        );
        if($filtro === '') {
            $sql = 'select * from city order by '. $orden .', name, countrycode, district, population, id limit :offset, :rpp';
        } else {
            $sql = 'select * from city
                    where id like :filtro or name like :filtro or countrycode like :filtro or district like :filtro or population like :filtro
                    order by '. $orden .', name, countrycode, district, population, id limit :offset, :rpp';
            $parametros['filtro'] = '%' . $filtro . '%';
        }
        $array = [];
        if($this->getDatabase()->connect()) {
            if($this->getDatabase()->execute($sql, $parametros)) {
                while($fila = $this->getDatabase()->getSentence()->fetch()) {
                    $objeto = new City();
                    $objeto->set($fila);
                    $array[] = $objeto;
                }
            }
        }
        
        $enlaces = $paginacion->values();
        return array(
            'paginas' => $enlaces,
            'ciudades' => $array,
            'rango' => $paginacion->range(5),
            'orden' => $orden,
            'filtro' => $filtro
        );
    }

    function login(Usuario $usuario) {
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $user = $entityManager->getRepository('izv\data\Usuario')
                                    ->findOneBy(array('correo' => $usuario->getCorreo()));
            if($user !== null) {
                if(Util::verificarClave($usuario->getClave(), $user->getClave())) {
                    $user->setClave('');
                }
            }
            
        } catch (\Exception $e) {
            return null;
        }
        
        return $user;
    }

    function register(Usuario $usuario) {
        $id;
        
        try {
            $entityManager = $this->getDatabase()->getEntityManager();
            $entityManager->persist($usuario);
            $entityManager->flush();
            $id = $usuario->getId();
            
        } catch (\Exception $e) {
            return 0;
        }
        
        return $id;
    }
    
    function getUsuario($id) {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $usuario = $manager->get($id);
        $db->close();
        return $usuario;
    }
    
    function editUsuario($usuario) {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $resultado = $manager->edit($usuario);
        $db->close();
        return $resultado;
    }
    
    function editWithPassword($usuario) {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $resultado = $manager->editWithPassword($usuario);
        $db->close();
        return $resultado;
    }
    
    function remove($id) {
        $db = new Database();
        $manager = new ManageUsuario($db);
        $resultado = $manager->remove($id);
        $db->close();
        return $resultado;
    }
    
}