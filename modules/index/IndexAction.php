<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Framework\Action;
use Framework\interfaces\RouteInterface;

class IndexAction extends Action
{
    public function __invoke(): ResponseInterface
    {
        $route = $this->request->getAttribute(RouteInterface::class);
        $psr17Factory = new Psr17Factory();
        $stream = $psr17Factory->createStream('
        <!DOCTYPE html>
        <html lang="ja">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="shortcut icon" href="/static/favicon.ico" type="image/x-icon">
            <title>The application worked successfully.</title>
        </head>
        <body style="margin:10px;">
            <p>The application worked successfully.</p>
            <hr>
            <p>module=' . $route->getModuleName() . ', action=' . $route->getActionName() . '</p>
        </body>
        </html>
        ');
        $response = $psr17Factory->createResponse();
        $response = $response->withAddedHeader("Content-Type", "text/html; charset=UTF-8");
        $response = $response->withBody($stream);
        return $response;
    }
}