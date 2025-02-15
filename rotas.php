<?php

use System\Controller\UserController;
use System\Controller\MainControllerl;
use System\Controller\TransactionsController;
use System\Core\Helpers;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Dispatcher para configurar as rotas e despachar requisições.
 *
 * @param RouteCollector $r Objeto para definir as rotas.
 */
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $url = SITE_URL;

    $r->addRoute(['GET', 'POST'], $url, 'System\Controller\MainController@index');

    $r->addRoute(['GET', 'POST'], "{$url}cadastrar-pessoa", 'System\Controller\UserController@personRecord');
    $r->addRoute(['GET', 'POST'], "{$url}cadastrar-transacao", 'System\Controller\TransactionsController@transactionRecord');

    $r->addRoute('GET', "{$url}deletar-pessoa/{id:\d+}", 'System\Controller\UserController@deletePerson');
    $r->addRoute('GET', "{$url}deletar-transacao/{id:\d+}", 'System\Controller\TransactionsController@deleteTransaction');

    $r->addRoute(['GET', 'POST'], "{$url}editar-pessoa/{id:\d+}", 'System\Controller\UserController@editPerson');
    $r->addRoute(['GET', 'POST'], "{$url}editar-transacao/{id:\d+}", 'System\Controller\TransactionsController@editTransaction');

    $r->addRoute(['GET', 'POST'], "{$url}totais", 'System\Controller\MainController@total');

    $r->addRoute('GET', "{$url}404", 'System\Controller\MainController@error404');


});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

/**
 * Despacha a requisição para o controlador e método adequados com base na rota.
 *
 * @param array $routeInfo Informações sobre a rota encontrada.
 */
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    case \FastRoute\Dispatcher::NOT_FOUND:
        Helpers::redirect('404');
        break;

    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        list($controller, $method) = explode('@', $handler);
        (new $controller)->$method(...array_values($vars));

        break;
}
