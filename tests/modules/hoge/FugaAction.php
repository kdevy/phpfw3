<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Framework\Action;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

class FugaAction extends Action
{
    public function setup(): void
    {
        return;
    }

    public function __invoke(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $stream = $psr17Factory->createStream("hello world");
        $response = $psr17Factory->createResponse();
        $response = $response->withBody($stream);
        return $response;
    }
}