<?php

//Diretório das entidades
$paths = [
    __DIR__ . "/../Entity"
];

//Definir modo de desenvolvimento
$isDevMode = true;

$cache = new Doctrine\Common\Cache\ArrayCache();

//Parâmetros de configuração do banco de dados
$dbParams = [
    "driver" => "pdo_mysql",
    "user" => "root",
    "password" => "",
    "dbname" => "doctrine_avancado_curso"
];

$config = new Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver($paths);
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);

//Configuração de Proxy
$config->setProxyDir(__DIR__ . "/Proxy");
$config->setProxyNamespace("App\Config\Proxy");

//Gerar proxy automaticamente
$config->setAutoGenerateProxyClasses(true);

//Configurar a forma de mapeamento 
//$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

//Gerente de entidades
$entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

function getEntityManager(){
    global $entityManager;
    return $entityManager;
}