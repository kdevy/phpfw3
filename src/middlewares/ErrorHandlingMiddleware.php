<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\middlewares;

use Framework\exceptions\NotFound404Error;
use Framework\exceptions\UnresolvableActionError;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlingMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (UnresolvableActionError | NotFound404Error $e) {
            $psr17Factory = new Psr17Factory();
            $body = "<p style='font-style: oblique;'>not found 404 ("
                . $request->getUri()->getPath() . ")<br><a href='/'>TOP</a></p>";
            $stream = $psr17Factory->createStream($body);
            $response = $psr17Factory->createResponse(404)->withBody($stream);
        }
        return $response;
    }
}
