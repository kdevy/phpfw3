<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

require(dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php");

use Framework\Application;
use Framework\ActionResolver;
use Framework\interfaces\ActionResolverInterface;
use DI\ContainerBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ApplicationTest extends TestCase
{
    public function testRun()
    {
        $factory = new Psr17Factory();
        $request = $factory->createServerRequest("GET", "/hoge/");
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            ActionResolverInterface::class => function (ContainerInterface $container) {
                $actionResolver = new ActionResolver();
                $actionResolver->setBasePath(__DIR__ . DIRECTORY_SEPARATOR . "modules");
                return $actionResolver;
            },
        ]);

        $container = $containerBuilder->build();

        $app = new Application(
            $container,
            $request,
            $container->get(ActionResolverInterface::class)
        );

        $response = $app->run(true);

        $this->assertSame("hello world", strval($response->getBody()));
    }
}