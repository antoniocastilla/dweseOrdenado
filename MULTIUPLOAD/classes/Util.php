<?php

class Util {
    function varDump($value) {
        return '<pre>' . var_export($value, true) . '</pre>';
    }
}