<?php

class Autoload {
  static function load($clase) {
    $ruta = dirname(__FILE__) . '/' . $clase . '.php';
    if (file_exists($ruta)) {
      require($ruta);
    }
  }
}
spl_autoload_register('Autoload::load');
//cada vez que se necesite una clase y no la encuentre, la cargue con
//el método load();