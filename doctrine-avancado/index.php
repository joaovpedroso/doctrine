<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/App/Config/doctrine.php";

use App\Entity\Categoria;
use App\Entity\Post;
use App\Entity\PostCategoria;

$entityManager = getEntityManager();

$categoria = new Categoria();
$categoria->setName("Proxy");

$entityManager->persist($categoria);
$entityManager->flush();

$categoria = $entityManager->getReference(App\Entity\Categoria::class, 2);