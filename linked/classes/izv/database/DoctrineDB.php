<?php

namespace izv\database;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineDB {
    
    private $entityManager;

    function __construct() {
        $paths = array('./dbobjects');
        $isDevMode = true;
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => 'links',
            'password' => 'links',
            'dbname'   => 'links',
            'charset'  => 'utf8'
        );
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $this->entityManager = EntityManager::create($dbParams, $config);
    }
    
    function getEntityManager() {
        return $this->entityManager;
    }
}