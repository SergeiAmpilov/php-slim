<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ExampleBeforeMiddleware implements IMiddleware
{
    /**
     * Пример промежуточного ПО как вызываемый класс.
     * Данное промежуточное ПО дописывает BEFORE в начало ответа
     *
     * @param  Request  $request PSR-7 запрос
     * @param  RequestHandler $handler PSR-15 обработчик запроса
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();

        $response = new Response();
        $response->getBody()->write('BEFORE ' . $existingContent);

        return $response;
    }


}