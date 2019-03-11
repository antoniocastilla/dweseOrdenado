<?php


require_once '../../autoload.php';
require_once '../../vendor/autoload.php';
//require_once '../app/App.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use framework\app\App;

$paths = array('./src');
$isDevMode = true;
$dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => App::USER,
            'password' => App::PASSWORD,
            'dbname'   => App::DATABASE,
            'charset'  => 'utf8'
        );
        
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create ($dbParams, $config); //gestor
//$config->addEntityNamespace('', 'src\entity');

/*
    Para meter el Namespace si fuera necesario.
    $driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver($entintyManager->getConnection()->getSchemaManager());
    $driver->setNamespace('dbobjects\\');
    $entityManager->getConfiguration()->setMetadataDriverImpl($driver);
*/