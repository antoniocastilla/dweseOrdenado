<?php

require_once("classes/vendor/autoload.php");

// Specify our Twig templates location
$loader = new \Twig_Loader_Filesystem(__DIR__ . '/twig');
// Instantiate our Twig
$twig = new \Twig_Environment($loader);

$lista = array();
$item = array('href' => 'http://example.com', 'caption' => 'enlace 1');
$lista[] = $item;
$item = array('href' => 'http://abc.es', 'caption' => 'enlace 2');
$lista[] = $item;
$item = array('href' => 'http://publico.es', 'caption' => 'enlace 3');
$lista[] = $item;

echo $twig->render('_bootstrap_landing.html', ['lista' => $lista]);