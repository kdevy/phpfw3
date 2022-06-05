<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Framework\Action;

class IndexAction extends Action
{
    public function __invoke(): ResponseInterface
    {
        $this->templateResponder->setExtendFilePath("extends/default.html");
        $contexts = $this->request->getAttribute("contexts");
        return $this->templateResponder->response($contexts);
    }
}