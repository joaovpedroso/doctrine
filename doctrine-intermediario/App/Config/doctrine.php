<?php

//Diretório das entidades
$paths = [
    __DIR__ . "/../Entity"
];

//Definir modo de desenvolvimento
$isDevMode = true;

//Parâmetros de configuração do banco de dados
$dbParams = [
    "driver" => "pdo_mysql",
    "user" => "root",
    "password" => "",
    "dbname" => "doctrine_intermediario_curso"
];

//Configurar a forma de mapeamento 
$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

//Gerente de entidades
$entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

function getEntityManager(){
    global $entityManager;
    return $entityManager;
}