<?php
use App\Entity\Post;
use \App\Entity\Category;
use \Psr\Http\Message\ServerRequestInterface;
use \Zend\Diactoros\Response;

$map->get("posts.list", "/posts", function($request, $response) use ($view, $entityManager) {

    $repository = $entityManager->getRepository(Post::class);
    $post = $repository->findAll();

    return $view->render($response, "posts/list.phtml", [
                "posts" => $post
    ]);
});

$map->get("posts.create", "/posts/create", function($request, $response) use($view) {
    return $view->render($response, "posts/create.phtml");
});

$map->post("posts.store", "/posts/store", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {

    $dados = $request->getParsedBody();

    //Nova Instância da Entity
    $post = new Post();
    //atribuir valores a instância
    $post->setTitulo($dados["titulo"]);
    $post->setTexto($dados["texto"]);
    //Deixar gerenciavel o obj da Entity
    $entityManager->persist($post);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("posts.list");

    return new Response\RedirectResponse($uri);
});


$map->get("posts.edit", "/posts/{id}/edit", function(ServerRequestInterface $request, $response) use($view, $entityManager) {
    $id = $request->getAttribute("id");

    $repository = $entityManager->getRepository(Post::class);
    $post = $repository->find($id);

    return $view->render($response, "posts/edit.phtml", [
                "posts" => $post
    ]);
});

$map->post("posts.update", "/posts/{id}/update", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    $id = $request->getAttribute("id");
    $repository = $entityManager->getRepository(Post::class);
    $post = $repository->find($id);

    //Receber dados vindos do formulario
    $dados = $request->getParsedBody();
    //atribuir valores a instância
    $post->setTitulo($dados["titulo"]);
    $post->setTexto($dados["texto"]);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("posts.list");

    return new Response\RedirectResponse($uri);
});

$map->get("posts.excluir", "/posts/{id}/excluir", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    $id = $request->getAttribute("id");
    $repository = $entityManager->getRepository(Post::class);
    $post = $repository->find($id);

    //Remover do repositório gerenciavel
    $entityManager->remove($post);
    //Executar ação no banco de dados
    $entityManager->flush();

    $uri = $generator->generate("posts.list");

    return new Response\RedirectResponse($uri);
});

$map->get("posts.categorias", "/posts/{id}/categorias", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    $id = $request->getAttribute("id");
    $repository = $entityManager->getRepository(Post::class);
    $categoriasRepository = $entityManager->getRepository(Category::class);
    $categorias = $categoriasRepository->findAll();
    $post = $repository->find($id);

    return $view->render($response, "posts/categorias.phtml", [
        "posts" => $post,
        "categorias" => $categorias
    ]);
});

$map->post("posts.set-categorias", "/posts/{id}/set-categorias", function(ServerRequestInterface $request, $response) use($view, $entityManager, $generator) {
    
    $id = $request->getAttribute("id");
    $dados = $request->getParsedBody();
    
    $categoriasRepository = $entityManager->getRepository(Category::class);
    $repository = $entityManager->getRepository(Post::class);
    $post = $repository->find($id);
    $post->getCategorias()->clear();
    $entityManager->flush();
    
    foreach($dados["categorias"] as $idCategoria){
        $categoria = $categoriasRepository->find($idCategoria);
        $post->addCategoria($categoria);
    }
    $entityManager->flush();
    

    $uri = $generator->generate("posts.list");
    return new Response\RedirectResponse($uri);
});
