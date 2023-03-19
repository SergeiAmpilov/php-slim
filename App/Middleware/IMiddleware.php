<?php


namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

interface IMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response;

}