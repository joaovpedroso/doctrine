<?php

use \Zend\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;
use \Aura\Router\RouterContainer;
use \Zend\Diactoros\Response;
use \Slim\Views\PhpRenderer;
use App\Entity\Post;
use \App\Entity\Category;

$request = ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$routerContainer = new RouterContainer();

$generator = $routerContainer->getGenerator();
$map = $routerContainer->getMap();
$view = new PhpRenderer(__DIR__ . "/../resources/views/");

$entityManager = getEntityManager();

$map->get("home", "/", function(ServerRequestInterface $request, $response) use ($view, $entityManager) {

    $postsRepository = $entityManager->getRepository(Post::class);
    $categoriasRepository = $entityManager->getRepository(Category::class);
    $categorias = $categoriasRepository->findAll();
    
    $dados = $request->getQueryParams();
    if( isset( $dados["search"] ) and ( $dados["search"] !== "" ) ){
        $queryBuilder = $postsRepository->createQueryBuilder("p");
        $queryBuilder->join("p.categorias", "c")->where( $queryBuilder->expr()->eq("c.id", $dados["search"]) );
        $post = $queryBuilder->getQuery()->getResult();
    }else{
        $post = $postsRepository->findAll();
    }
    

    return $view->render($response, "home.phtml", [
        "posts" => $post,
        "categorias" => $categorias
    ]);
});

require_once __DIR__ . "/categorias.php";
require_once __DIR__ . "/posts.php";

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

//Coletar os atributos da requisição
foreach ($route->attributes as $key => $value) {
    $request = $request->withAttribute($key, $value);
}

$callable = $route->handler;

$response = $callable($request, new Response());

if ($response instanceof Response\RedirectResponse) {
    header("location: {$response->getHeader("location")[0]}");
} elseif ($response instanceof Response) {
    echo $response->getBody();
}
