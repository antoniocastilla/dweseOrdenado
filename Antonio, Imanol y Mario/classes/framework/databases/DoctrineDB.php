<?php

namespace framework\databases;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use framework\app\App;

class DoctrineDB {
    
    private $entityManager;

    function __construct() {
        $paths = array('./dbobjects');
        $isDevMode = true;
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => App::USER,
            'password' => App::PASSWORD,
            'dbname'   => App::DATABASE,
            'charset'  => 'utf8'
        );
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }
    
    function getEntityManager() {
        return $this->entityManager;
    }
}