<?php

namespace izv\tools;

class Util {

    static function alert($message, $type = 'alert-success') {
        return '<div class="alert ' . $type . '" role="alert">' .
                $message .
                '</div>';
    }

    static function dangerAlert($message = 'Alert!') {
        return self::alert($message, 'alert-danger');
    }

    static function okAlert($message = 'Ok!') {
        return self::alert($message);
    }

    static function varDump($value) {
        return '<pre>' . var_export($value, true) . '</pre>';
    }
    
    static function url() {
        $url = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $parts = pathinfo($url);
        return $parts['dirname'] . '/';
    }
}