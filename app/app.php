<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Application;
use Framework\ServerRequestFromGlovalCreator;
use Framework\ActionResolver;
use Framework\MiddlewareDispatcher;
use Framework\TemplateResponder;
use Framework\interfaces\ActionResolverInterface;
use Framework\interfaces\MiddlewareDispatcherInterface;
use Framework\interfaces\TemplateResponderInterface;
use Framework\middlewares\DebuggingMiddleware;
use Framework\middlewares\ErrorHandlingMiddleware;

require_once __DIR__ . DS . "includes/config.php";

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    ServerRequestInterface::class => function (ContainerInterface $container) {
        return ServerRequestFromGlovalCreator::create();
    },
    ActionResolverInterface::class => function (ContainerInterface $container) {
        $actionResolver = new ActionResolver($container->get(TemplateResponderInterface::class));
        $actionResolver->setBasePath(realpath(APP_DIR . DS . "modules"));
        return $actionResolver;
    },
    MiddlewareDispatcherInterface::class => function (ContainerInterface $container) {
        $middlewareDispatcher = new MiddlewareDispatcher($container->get(ActionResolverInterface::class), $container);
        $middlewareDispatcher->add(new DebuggingMiddleware());
        $middlewareDispatcher->add(new ErrorHandlingMiddleware());
        return $middlewareDispatcher;
    },
    TemplateResponderInterface::class => function (ContainerInterface $container) {
        $templateResponder = new TemplateResponder($container->get(ServerRequestInterface::class));
        $templateResponder->setBasePath(realpath(BASE_DIR . DS . "templates"));
        return $templateResponder;
    }
]);

$container = $containerBuilder->build();

$app = new Application(
    $container,
    $container->get(ServerRequestInterface::class),
    $container->get(ActionResolverInterface::class),
    $container->get(MiddlewareDispatcherInterface::class)
);

return $app;
