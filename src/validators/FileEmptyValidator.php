<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

use Psr\Http\Message\ServerRequestInterface;

/**
 * 空でないかどうか
 */
class FileEmptyValidator extends Validator
{
    /**
     * @param string $name
     * @param ServerRequestInterface $request
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $name,
        protected ServerRequestInterface $request,
        protected string $message = "%{placeholder}を選択してください。",
        protected array $contexts = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        $files = $this->request->getUploadedFiles();
        return $files[$this->name]["name"] ?? false;
    }
}
