<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php");

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Framework\Route;

class RouteTest extends TestCase
{
    public function testGetModuleName()
    {
        $factory = new Psr17Factory();
        $request = $factory->createRequest("GET", "/");
        $route = new Route($request);
        $this->assertSame("index", $route->getModuleName());
    }
}
