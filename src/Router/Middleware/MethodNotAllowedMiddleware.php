<?php

declare(strict_types=1);

namespace SnappyApplication\Router\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SnappyApplication\ErrorHandler\ErrorHandlerInterface;
use Throwable;

class MethodNotAllowedMiddleware implements MiddlewareInterface
{
    private ErrorHandlerInterface $errorHandler;

    private Throwable $throwable;

    public function __construct(ErrorHandlerInterface $errorHandler, Throwable $throwable)
    {
        $this->errorHandler = $errorHandler;
        $this->throwable = $throwable;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->errorHandler->handle($this->throwable, $request)->withStatus(405);
    }
}