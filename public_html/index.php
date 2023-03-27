<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new \DI\Container();
AppFactory::setContainer($container);

// Инициализация приложения
$app = AppFactory::create();


$container = $app->getContainer();
$container->set('view', function(\Psr\Container\ContainerInterface $container){
    return new \Slim\Views\Twig('');
});

// Добавление промежуточного ПО обработки ошибок
$app->addErrorMiddleware(true, false, false);

// Добавления маршрута с обратным вызовом
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write('Hello World');
    return $response;
});

// Запуск приложения
$app->run();