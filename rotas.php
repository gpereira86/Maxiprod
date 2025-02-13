<?php

use System\Controller\UserController;
use System\Core\Helpers;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $url = SITE_URL;

    $r->addRoute('GET', $url, 'system\Controller\SiteController@index');
    $r->addRoute(['GET', 'POST'], "{$url}cadastrar-pessoa", 'system\Controller\SiteController@personRecord');
    $r->addRoute('GET', "{$url}deletar-pessoa/{id:\d+}", 'system\Controller\SiteController@deletePerson');
    $r->addRoute(['GET', 'POST'], "{$url}editar-pessoa/{id:\d+}", 'system\Controller\SiteController@editPerson');


//    $r->addRoute('POST', "{$url}cadastrar", 'system\Controller\UserController@saveRegister');
    $r->addRoute(['GET', 'POST'], "{$url}salvar-edicao/{id:\d+}", 'system\Controller\SiteController@updateRegister');
    $r->addRoute('GET', "{$url}404", 'system\Controller\SiteControlador@error404');
});



// Capture the HTTP method and requested URI.
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Remove query string from the URI, if present.
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

// Dispatch the request and determine the route information.
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);


switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    case \FastRoute\Dispatcher::NOT_FOUND:
        // Redirect to a 404 error page.
        Helpers::redirect('404');
        break;

    case \FastRoute\Dispatcher::FOUND:
        // Retrieve the handler and route variables.
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Extract `id` or `slug` from the route variables.
        $id = $vars['id'] ?? null;
        $slug = $vars['slug'] ?? null;
        $variavel = $id ?? $slug;

        // Parse the handler to extract the class and method.
        $handlerParts = explode('@', $handler);
        $controllerClass = $handlerParts[0];
        $controllerMethod = $handlerParts[1];

        // Instantiate the controller and call the appropriate method.
        $siteController = new UserController();
        $siteController->$controllerMethod($variavel, $vars['pagina'] ?? null);

        break;
}
