<?php
use \App\Entity\Category;
use \Psr\Http\Message\ServerRequestInterface;
use \Zend\Diactoros\Response;

$map->get("categorias.list", "/categorias", function($request, $response) use ($view, $entityManager) {

    $repository = $entityManager->getRepository(Category::class);
    $categorias = $repository->findAll();

    return $view->render($response, "categorias/list.phtml", [
                "categorias" => $categorias
    ]);
});

$map->get("categorias.create", "/categorias/create", function($request, $response) use($view) {
    return $view->render($response, "categorias/create.phtml");
});

$map->post("categorias.store", "/categorias/store", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {

    $dados = $request->getParsedBody();

    //Nova Instância da Entity
    $categoria = new Category();
    //atribuir valores a instância
    $categoria->setNome($dados["nome"]);
    //Deixar gerenciavel o obj da Entity
    $entityManager->persist($categoria);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("categorias.list");

    return new Response\RedirectResponse($uri);
});


$map->get("categorias.edit", "/categorias/{id}/edit", function(ServerRequestInterface $request, $response) use($view, $entityManager) {
    $id = $request->getAttribute("id");

    $repository = $entityManager->getRepository(Category::class);
    $categoria = $repository->find($id);

    return $view->render($response, "categorias/edit.phtml", [
                "categoria" => $categoria
    ]);
});

$map->post("categorias.update", "/categorias/{id}/update", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    $id = $request->getAttribute("id");
    $repository = $entityManager->getRepository(Category::class);
    $categoria = $repository->find($id);

    //Receber dados vindos do formulario
    $dados = $request->getParsedBody();
    //atribuir valores a instância
    $categoria->setNome($dados["nome"]);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("categorias.list");

    return new Response\RedirectResponse($uri);
});

$map->get("categorias.excluir", "/categorias/{id}/excluir", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    $id = $request->getAttribute("id");
    $repository = $entityManager->getRepository(Category::class);
    $categoria = $repository->find($id);

    //Remover do repositório gerenciavel
    $entityManager->remove($categoria);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("categorias.list");

    return new Response\RedirectResponse($uri);
});
