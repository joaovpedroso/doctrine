<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../App/Config/doctrine.php";

$entityManager = getEntityManager();

$categoria = new App\Entity\Categoria();
$categoria = $entityManager->find("\App\Entity\Categoria", 2);
//$categoria->setName("Cidade");

$usuario = new App\Entity\User();
$usuario->setNome("Joao Victor");

$post = new App\Entity\Post();
$post->setTitulo("Primeiro Post - ManyToOne");
$post->setTexto("123");
//$post->addCategoria($categoria);
$post->setUser($usuario);


//Tornar a entidade gerenciavel
$entityManager->persist($usuario);
$entityManager->persist($post);
//$entityManager->persist($categoria);

//Efetivar a ação no banco de dados
$entityManager->flush();