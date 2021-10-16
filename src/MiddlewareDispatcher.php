<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Framework\interfaces\MiddlewareDispatcherInterface;
use Framework\interfaces\ActionResolverInterface;
use Closure;

class MiddlewareDispatcher implements MiddlewareDispatcherInterface
{
    /**
     * Middleware queue.
     *
     * @var array
     */
    private array $middlewares = [];

    /**
     * @var ActionResolverInterface
     */
    private ActionResolverInterface $actionResolver;

    /**
     * @var ContainerInterface|null
     */
    private ?ContainerInterface $container = null;

    /**
     * @param RequestHandlerInterface $actionResolver
     * @param ContainerInterface|null $container
     */
    public function __construct(ActionResolverInterface $actionResolver, ?ContainerInterface $container = null)
    {
        $this->actionResolver = $actionResolver;
        $this->container = $container;
    }

    /**
     * The added middleware is traversed in the FIFO.
     *
     * @param MiddlewareInterface|Closure|string $middleware
     * @return MiddlewareDispatcherInterface
     */
    public function add($middleware): MiddlewareDispatcherInterface
    {
        if ($middleware instanceof MiddlewareInterface) {
            $this->addMiddleware($middleware);
            return $this;
        }
        if ($middleware instanceof Closure) {
            $this->addClosure($middleware);
            return $this;
        }
        if (is_subclass_of($middleware, MiddlewareInterface::class)) {
            $this->addClassString($middleware);
            return $this;
        }

        throw new \RuntimeException(
            "Invalid middleware was passed, " .
                "Must be a closure or an object/class that implements MiddlewareInterface."
        );
    }

    /**
     * Add middleware from middleware instance.
     *
     * @param MiddlewareInterface $middleware
     * @return void
     */
    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Add middleware from closure.
     *
     * @param Closure $middleware
     * @return void
     */
    public function addClosure(Closure $middleware): void
    {
        $middleware = Closure::bind($middleware, $this->container);
        $this->middlewares[] = new class($middleware) implements MiddlewareInterface
        {
            public function __construct($middleware)
            {
                $this->middleware = $middleware;
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                return ($this->middleware)($request, $handler);
            }
        };
    }

    /**
     * Add middleware from class string.
     *
     * @param string $middleware
     * @return void
     */
    public function addClassString(string $middleware): void
    {
        $this->middlewares[] = new $middleware();
    }

    /**
     * Traverse middleware queue.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = current($this->middlewares);
        next($this->middlewares);

        // Call the main process when the middleware queue traverse is complete.
        if (!$middleware) {
            $action = $this->actionResolver->resolve($request);
            $action->setup();
            return ($action)();
        }
        return $middleware->process($request, $this);
    }
}