<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Framework\ActionResolver;
use Framework\Application;
use Framework\interfaces\ActionResolverInterface;
use Framework\interfaces\MiddlewareDispatcherInterface;
use Framework\interfaces\TemplateResponderInterface;
use Framework\MiddlewareDispatcher;
use Framework\middlewares\DebuggingMiddleware;
use Framework\middlewares\ErrorHandlingMiddleware;
use Framework\ServerRequestFromGlovalCreator;
use Framework\TemplateResponder;
use Psr\Http\Message\ServerRequestInterface;

$sttime = microtime(true);

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    ServerRequestInterface::class => function (ContainerInterface $container) {
        return ServerRequestFromGlovalCreator::create();
    },
    ActionResolverInterface::class => function (ContainerInterface $container) {
        $actionResolver = new ActionResolver();
        $actionResolver->setBasePath(__DIR__ . DIRECTORY_SEPARATOR . "modules");
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
        $templateResponder->setBasePath(realpath(__DIR__ . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR));
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

$app->run();