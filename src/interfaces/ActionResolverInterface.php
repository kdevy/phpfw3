<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\interfaces;

use Psr\Http\Message\ServerRequestInterface;

interface ActionResolverInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return callable
     */
    public function resolve(ServerRequestInterface $request): ActionInterface;
}