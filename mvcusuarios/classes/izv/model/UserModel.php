<?php

namespace izv\model;

use izv\data\City;
use izv\data\Usuario;
use izv\database\Database;
use izv\managedata\ManageCity;
use izv\managedata\ManageUsuario;
use izv\tools\Pagination;

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

    function getTotalCiudades() {
        $ciudades = 0;
        if($this->getDatabase()->connect()) {
            $sql = 'select count(*) from city';
            if($this->getDatabase()->execute($sql)) {
                if($fila = $this->getDatabase()->getSentence()->fetch()) {
                    $ciudades = $fila[0];
                }
            }
        }
        return $ciudades;
    }

    function login(Usuario $usuario) {
        $manager = new ManageUsuario($this->getDatabase());
        return $manager->login($usuario->getCorreo(), $usuario->getClave());
    }

    function register(Usuario $usuario) {
        $manager = new ManageUsuario($this->getDatabase());
        $r = $manager->add($usuario);
        if($r > 0) {
            $usuario->setId($r);
        }
        return $r;
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
    
}