<?php

use System\Controller\UserController;
use System\Controller\MainControllerl;
use System\Controller\TransactionsController;
use System\Core\Helpers;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $url = SITE_URL;

    $r->addRoute(['GET', 'POST'], $url, 'System\Controller\MainController@index');

    $r->addRoute(['GET', 'POST'], "{$url}cadastrar-pessoa", 'System\Controller\UserController@personRecord');
    $r->addRoute('GET', "{$url}deletar-pessoa/{id:\d+}", 'System\Controller\UserController@deletePerson');
    $r->addRoute(['GET', 'POST'], "{$url}editar-pessoa/{id:\d+}", 'System\Controller\UserController@editPerson');

    $r->addRoute(['GET', 'POST'], "{$url}cadastrar-transacao", 'System\Controller\TransactionsController@transactionRecord');
    $r->addRoute('GET', "{$url}deletar-transacao/{id:\d+}", 'System\Controller\TransactionsController@deleteTransaction');
    $r->addRoute(['GET', 'POST'], "{$url}editar-transacao/{id:\d+}", 'System\Controller\TransactionsController@editTransaction');

    $r->addRoute(['GET', 'POST'], "{$url}totais", 'System\Controller\MainController@total');

    $r->addRoute('GET', "{$url}404", 'System\Controller\MainController@error404');
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

        $siteController = new $controllerClass;
        $siteController->$controllerMethod($variavel, $vars['pagina'] ?? null);

        break;
}
