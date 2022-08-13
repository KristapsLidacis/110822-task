<?php
require_once 'vendor/autoload.php';

use App\View;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/register', 'App\Controllers\RegisterController@showForm');
    $r->addRoute('POST', '/register', 'App\Controllers\RegisterController@store');
    $r->addRoute('GET', '/login', 'App\Controllers\LoginController@showForm');
    $r->addRoute('POST', '/login', 'App\Controllers\LoginController@auth');
    $r->addRoute('GET', '/logout', 'App\Controllers\LoginController@logout');

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

var_dump($_SESSION);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:

        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];

        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);
        $loader = new \Twig\Loader\FilesystemLoader('app/Views');
        $twig = new \Twig\Environment($loader);


        $container = new \DI\Container();
        $container->set(\App\Repositories\UserRepository::class, DI\create(\App\Repositories\MySQLUserRepository::class));


        /** @var View $view */
        $view = ($container->get($controller))->$method();
        if($view){
            $template = $twig->load($view->getTemplatePath(). '.twig');
            echo $template->render($view->getData());
        }


        break;
}