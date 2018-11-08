<?php

spl_autoload_register(
  function ($clase) {
    $archivo = dirname(__FILE__) . '/' . str_replace('\\', '/', $clase) . '.php';
    if (file_exists($archivo)) {
      require($archivo);
    }
});