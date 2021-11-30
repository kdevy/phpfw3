<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use DI\Container;
use Framework\interfaces\ActionResolverInterface;
use Framework\interfaces\MiddlewareDispatcherInterface;
use Framework\interfaces\RouteInterface;
use Framework\interfaces\TemplateResponderInterface;
use Framework\ActionResolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

class Application
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * @var ServerRequestInterface
     */
    private ServerRequestInterface $request;

    /**
     * @var ActionResolverInterface
     */
    private ActionResolverInterface $actionResolver;

    /**
     * @var EmitterInterface
     */
    private EmitterInterface $emitter;

    /**
     * @var MiddlewareDispatcher
     */
    private MiddlewareDispatcher $middlewareDispatcher;

    /**
     * @var RouteInterface
     */
    private RouteInterface $route;

    /**
     * @param ContainerInterface|null $container
     */
    public function __construct(
        ?ContainerInterface $container = null,
        ?ServerRequestInterface $request = null,
        ?ActionResolverInterface $actionResolver = null,
        ?MiddlewareDispatcherInterface $middlewareDispatcher = null,
        ?EmitterInterface $emitter = null,
        ?RouteInterface $route = null
    ) {
        $this->container = $container ?? new Container();

        $this->request = $request ?? ServerRequestFromGlovalCreator::create();

        $templateResponder = $container->has(TemplateResponderInterface::class) ? $container->get(TemplateResponderInterface::class) : new TemplateResponder($this->request);
        $this->actionResolver = $actionResolver ?? new ActionResolver($templateResponder);

        $this->middlewareDispatcher = $middlewareDispatcher ?? new MiddlewareDispatcher(
            $this->actionResolver,
            $this->container
        );

        $this->route = $route ?? new Route($this->request);

        $this->emitter = $emitter ?? new SapiEmitter();
    }

    /**
     * @param boolean $isSilent
     * @return ResponseInterface
     */
    public function run(bool $isSilent = false): ResponseInterface
    {
        $this->request = $this->request->withAttribute(RouteInterface::class, $this->route);
        $response = $this->middlewareDispatcher->handle($this->request);

        if (!$isSilent) {
            $this->emitter->emit($response);
        }

        return $response;
    }
}
