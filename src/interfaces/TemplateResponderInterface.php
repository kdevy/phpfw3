<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\interfaces;

use Psr\Http\Message\ResponseInterface;

interface TemplateResponderInterface
{
    /**
     * @return ResponseInterface
     */
    public function response(): ResponseInterface;

    /**
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @param string $basePath
     * @return void
     */
    public function setBasePath(string $basePath): void;
}