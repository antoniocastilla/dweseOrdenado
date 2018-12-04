<?php

require_once('classes/vendor/autoload.php');

$loader = new \Twig_Loader_Filesystem(__DIR__. '/twig');//Loader
$twig = new \Twig_Environment($loader);

//Pasandole un array
//echo $twig->render('base.html', array('placeholder' => 'twig',
//                                      'subtitulo' => 'otro'));

//echo $twig->render('base.twig');
//echo $twig->render('hereda.twig');
//echo $twig->render('hereda.twig', ['body' => 'reemplazado 1', 'otrocontenido' => 'reemplazado 2']);
echo $twig->render('hereda.twig');