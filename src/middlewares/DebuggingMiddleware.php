<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\interfaces\RouteInterface;

class DebuggingMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        /** @var RouteInterface */
        $route = $request->getAttribute(RouteInterface::class);
        $body = $response->getBody();
        $contentType = $response->getHeader("Content-Type")[0] ?? "";

        $lap = substr((string)(microtime(true) - APP_START_TIME), 0, 8);
        $mu = floor(memory_get_usage(true) / 1024);
        $mpu = floor(memory_get_peak_usage(true) / 1024);

        // Output debug infomation.
        if (str_contains($contentType, "text/html") && !empty($body)) {
            $body->write("<div id='debugWindow' style='position:fixed; bottom:0; left:0; overflow:auto; width:100%; z-index:99;'>"
                . "<table border='1' style='width:100%; border-collapse:collapse; font-size:14px;'>"
                . "<th colspan='10' style='text-align:left;'>Debug infomation</th>"
                . "<tr>"
                . "<td style='background:#dfdfdf;'>LAP(s)</td><td>{$lap}</td>"
                . "<td style='background:#dfdfdf;'>MU(Kb)</td><td>{$mu}</td>"
                . "<td style='background:#dfdfdf;'>MPU(Kb)</td><td>{$mpu}</td>"
                . "<td style='background:#dfdfdf;'>MODULE</td><td>" . $route->getModuleName() . "</td>"
                . "<td style='background:#dfdfdf;'>ACTION</td><td>" . $route->getActionName() . "</td>"
                . "</tr>"
                . "</table></div>");
            $response = $response->withBody($body);
        }

        syslog(LOG_INFO, sprintf("Application status: lap=%s, mu=%s kb, mpu=%s kb", $lap, $mu, $mpu));
        return $response;
    }
}
