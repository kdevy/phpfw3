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
     * @param array $contexts
     * @param integer $statusCode
     * @param array $headers
     * @return ResponseInterface
     */
    public function response(array $contexts = [], int $statusCode = 200, array $headers = []): ResponseInterface;

    /**
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @param string $basePath
     * @return void
     */
    public function setBasePath(string $basePath): void;

    /**
     * @return string
     */
    public function getExtendFilePath(): string;

    /**
     * @param string $extendFilePath
     * @return void
     */
    public function setExtendFilePath(string $extendFilePath): void;
}