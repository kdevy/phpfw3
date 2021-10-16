<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\interfaces;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getModuleName(): string;

    /**
     * @return string
     */
    public function getActionName(): string;

    /**
     * @return array
     */
    public function getPath(): array;

    /**
     * @return string
     */
    public function getPathName(): string;
}