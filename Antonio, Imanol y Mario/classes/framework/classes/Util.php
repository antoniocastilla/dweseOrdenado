<?php

namespace framework\classes;

class Util {
    
    static function dateFromSql($date) {
        return 'formato europeo de la fecha';
    }

    static function encriptar($cadena, $coste = 10) {
        $opciones = array(
            'cost' => $coste
        );
        return password_hash($cadena, PASSWORD_DEFAULT, $opciones);
    }

    static function getRouteAction() {
        $respuesta = new \stdClass();
        $respuesta->ruta = '';
        $respuesta->accion = '';
        $param = Reader::read('parametros');
        if($param !== null) {
            $partes = explode('/', $param);
            if(isset($partes[0])) {
                $respuesta->ruta = $partes[0];
            }
            if(isset($partes[1])) {
                $respuesta->accion = $partes[1];
            }
        }
        return $respuesta;
    }

    static function getDateFromMySqlToEs($mySqlDate) {
        date_default_timezone_set('Europe/Madrid');
        if ($mySqlDate === null) {
            return null;
        }
        return date("d/m/Y", strtotime($mySqlDate));
    }
    
    static function getDateHourFromMySqlToEs($mySqlDate) {
        date_default_timezone_set('Europe/Madrid');
        if ($mySqlDate === null) {
            return null;
        }
        return date("d/m/Y H:i:s", strtotime($mySqlDate));
    }
    
    static function getMonthYearFromDoctrine($doctrine) {
        date_default_timezone_set('Europe/Madrid');
        if ($doctrine === null) {
            return null;
        }
        return date("Y-m", strtotime($doctrine));
    }
    
    static function setDateHourToMySql($date) {
        date_default_timezone_set('Europe/Madrid');
        $date = str_replace('/', '-', $date);
        return date('Y-m-d H:i:s', strtotime($date));
    }
    
    static function setDateToMySql($date) {
        date_default_timezone_set('Europe/Madrid');
        $date = str_replace('/', '-', $date);
        return date('Y-m-d', strtotime($date));
    }
    
    static function setDateToDoctrine($date) {
        date_default_timezone_set('Europe/Madrid');
        $date = str_replace('/', '-', $date);
        return date('Y-m-d H:i:s', strtotime($date));
    }

    static function url() {
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = pathinfo($url);
        return $parts['dirname'] . '/';
    }

    static function varDump($value) {
        return '<pre>' . var_export($value, true) . '</pre>';
    }

    static function verificarClave($claveSinEncriptar, $claveEncriptada) {
        return password_verify($claveSinEncriptar, $claveEncriptada);
    }
    
    static function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
}