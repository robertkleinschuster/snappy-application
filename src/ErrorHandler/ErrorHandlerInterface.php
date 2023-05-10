<?php

declare(strict_types=1);

namespace SnappyApplication\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorHandlerInterface
{
    public function handle(Throwable $throwable, ?ServerRequestInterface $request = null): ResponseInterface;
}