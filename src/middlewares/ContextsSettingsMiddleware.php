<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\middlewares;

use Framework\interfaces\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContextsSettingsMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE_NAME = "contexts";

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var RouteInterface */
        $route = $request->getAttribute(RouteInterface::class);
        $contexts = [
            "module" => $route->getModuleName(),
            "action" => $route->getActionName(),
        ];
        $request = $request->withAttribute(self::ATTRIBUTE_NAME, $contexts);
        $response = $handler->handle($request);

        return $response;
    }
}
