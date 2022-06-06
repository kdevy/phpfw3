<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Framework\Action;
use Framework\interfaces\SessionInterface;
use Framework\middlewares\ContextsSettingsMiddleware;

class IndexAction extends Action
{
    public function __invoke(): ResponseInterface
    {
        $this->templateResponder->setExtendFilePath("extends/default.html");
        $contexts = $this->request->getAttribute(ContextsSettingsMiddleware::ATTRIBUTE_NAME);
        $session = $this->request->getAttribute(SessionInterface::class);
        
        $count = $session->get("count", 0);
        $session->set("count",$count + 1);
        $contexts["count"] = $count;

        return $this->templateResponder->response($contexts);
    }
}