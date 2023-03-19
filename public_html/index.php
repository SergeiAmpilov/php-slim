<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Middleware\ExampleBeforeMiddleware;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Создание контейнера PHP-DI
$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

$app->add(\App\Middleware\JsonBodyParserMiddleware::class);



/**
 * Add Error Handling Middleware
 *
 * @param bool $displayErrorDetails -> Should be set to false in production
 * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
 * @param bool $logErrorDetails -> Display error details in error log
 * which can be replaced by a callable of your choice.

 * Note: This middleware should be added last. It will not handle any exceptions/errors
 * for middleware added after it.
 */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
})->add(new ExampleBeforeMiddleware())->add(new \App\Middleware\ExampleAfterMiddleware());

$app->post('/', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();
    $response->getBody()->write("<pre>" . print_r($parsedBody,1) . "</pre>");
    return $response;
});

$app->get('/hello/[{name}]', function (Request $request, Response $response, array $args) {
    if (empty($args['name'])) {
        $name = 'demo';
    } else {
        $name = $args['name'];
    }

    $response->getBody()->write("Helllo, $name");
    return $response;
});


$app->run();