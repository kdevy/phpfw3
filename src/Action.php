<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Framework\interfaces\ActionInterface;
use Framework\interfaces\TemplateResponderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Action implements ActionInterface
{
    /**
     * @var ServerRequestInterface
     */
    protected ServerRequestInterface $request;

    /**
     * @var TemplateResponderInterface
     */
    protected TemplateResponderInterface $templateResponder;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request, TemplateResponderInterface $templateResponder)
    {
        $this->request = $request;
        $this->templateResponder = $templateResponder;
    }

    /**
     * @return void
     */
    public function setup(): void
    {
        return;
    }

    /**
     * @return ResponseInterface
     */
    abstract public function __invoke(): ResponseInterface;

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * @param ServerRequestInterface $request
     * @return void
     */
    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getContexts(): array
    {
        return [];
    }
}