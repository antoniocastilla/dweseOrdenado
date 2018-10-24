<?php

$archivo = $_GET['nombre'];
header('Content-type: image/jpeg');
readfile('../../../privado/' . $archivo);