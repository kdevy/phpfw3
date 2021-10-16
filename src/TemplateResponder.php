<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Framework\interfaces\RouteInterface;
use Framework\interfaces\TemplateResponderInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class TemplateResponder implements TemplateResponderInterface
{
    /**
     * @var ServerRequestInterface
     */
    private ServerRequestInterface $request;

    /**
     * @var string
     */
    private string $basePath;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     * @return void
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @param integer $statusCode
     * @param array $headers
     * @param string $body
     * @return ResponseInterface
     */
    public function responseFromBody(string $body, $statusCode = 200, array $headers = []): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $resonse = $psr17Factory->createResponse($statusCode);
        $stream = $psr17Factory->createStream($body);
        $resonse = $resonse->withBody($stream);

        foreach ($headers as $key => $value) {
            $resonse = $resonse->withHeader($key, $value);
        }
        if (!$resonse->hasHeader("Content-Type")) {
            $resonse = $resonse->withAddedHeader("Content-Type", "text/html;");
        }

        return $resonse;
    }

    /**
     * @return ResponseInterface
     */
    public function response(): ResponseInterface
    {
        /** @var RouteInterface */
        $route = $this->request->getAttribute(RouteInterface::class);
        $templatePath = realpath($this->basePath . DIRECTORY_SEPARATOR
            . $route->getModuleName() . DIRECTORY_SEPARATOR . $route->getActionName() . ".html");

        if (is_readable($templatePath)) {
            throw new RuntimeException("Template file not unreadable ({$templatePath}).");
        }

        $body = file_get_contents($templatePath);

        return $this->responseFromBody($body);
    }
}