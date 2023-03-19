<?php


namespace App\Middleware;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ExampleAfterMiddleware
{

    /**
     * Пример промежуточного ПО как вызываемый класс.
     * Данное промежуточное ПО дописывает AFTER в конец ответа
     *
     * @param  Request  $request PSR-7 запрос
     * @param  RequestHandler $handler PSR-15 обработчик запроса
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $response->getBody()->write('AFTER');
        return $response;
    }
}