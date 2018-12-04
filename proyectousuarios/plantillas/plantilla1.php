<?php

require_once('classes/vendor/autoload.php');

$loader = new \Twig_Loader_Filesystem(__DIR__. '/twig');//Loader
$twig = new \Twig_Environment($loader);

//Pasandole un array
//echo $twig->render('base.html', array('placeholder' => 'twig',
//                                      'subtitulo' => 'otro'));

echo $twig->render('base.html', ['placeholder' => 'twig', 'subtitulo' => 'otro']);