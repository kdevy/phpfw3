<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\middlewares;

use Framework\interfaces\SessionInterface;
use Framework\Session;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    private SessionInterface $session;

   /**
    * @param array $options
    */
    public function __construct(private array $options=[])
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!IS_CLI) {
            session_start($this->options);
        }

        $this->session = new Session();

        $request = $request->withAttribute(SessionInterface::class, $this->session);
        $response = $handler->handle($request);

        return $response;
    }
}
