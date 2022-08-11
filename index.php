<?php
require_once 'vendor/autoload.php';

use App\View;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/register', 'App\Controllers\RegistrationController@showForm');
    $r->addRoute('POST', '/register', 'App\Controllers\RegistrationController@store');
   // $r->addRoute('GET', '/login', 'App\Controllers\RegistrationController@showForm');
    $r->addRoute('GET', '/login', 'App\Controllers\RegistrationController@store');

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
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
        $container->set(\App\Repositories\Registration::class, DI\create(\App\Repositories\RegistrationRepository::class));


        /** @var View $view */
        $view = ($container->get($controller))->$method();

        $template = $twig->load($view->getTemplatePath());
        echo $template->render();

        break;
}