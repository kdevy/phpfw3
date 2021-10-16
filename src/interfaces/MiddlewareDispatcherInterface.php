<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\interfaces;

use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareDispatcherInterface extends RequestHandlerInterface
{
    /**
     * @param mixed $middleware
     * @return MiddlewareDispatcher
     */
    public function add($middleware): MiddlewareDispatcherInterface;
}