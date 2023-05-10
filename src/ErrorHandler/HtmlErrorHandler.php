<?php

declare(strict_types=1);

namespace SnappyApplication\ErrorHandler;

use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\HttpExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SnappyRenderer\Exception\RenderException;
use SnappyRenderer\Helper\Arguments;
use SnappyRenderer\Renderer;
use Throwable;

class HtmlErrorHandler implements ErrorHandlerInterface
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * @throws RenderException
     */
    public function handle(Throwable $throwable, ?ServerRequestInterface $request = null): ResponseInterface
    {
        if ($throwable instanceof HttpExceptionInterface) {
            return new HtmlResponse(
                $this->renderer->render(
                    include 'View/Error.php',
                    new Arguments(
                        [
                            'message' => $throwable->getMessage(),
                            'code' => $throwable->getStatusCode(),
                            'request' => $request
                        ]
                    )
                ),
                $throwable->getStatusCode()
            );
        }
        return new HtmlResponse(
            $this->renderer->render(
                include 'View/Error.php',
                new Arguments(
                    [
                        'message' => 'Internal Server Error',
                        'code' => 500,
                        'request' => $request
                    ]
                )
            ),
            500
        );
    }
}