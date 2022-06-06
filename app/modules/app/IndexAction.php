<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Framework\Action;
use Framework\middlewares\ContextsSettingsMiddleware;

class IndexAction extends Action
{
    public function __invoke(): ResponseInterface
    {
        $contexts = $this->request->getAttribute(ContextsSettingsMiddleware::ATTRIBUTE_NAME);
        return $this->templateResponder->response($contexts);
    }
}