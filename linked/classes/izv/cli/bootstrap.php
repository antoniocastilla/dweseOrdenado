<?php
require_once "../../vendor/autoload.php";
require_once "../../autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = false;
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'links',
    'user'     => 'links',
    'password' => 'links'
);

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/src'), $isDevMode);
$entityManager = EntityManager::create($conn, $config);