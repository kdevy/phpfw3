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
 * ファイル拡張子チェック
 */
class FileExtensionValidator extends Validator
{
    /**
     * @param array $extensions
     * @param string $name
     * @param ServerRequestInterface $request
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected array $extensions,
        protected string $name,
        protected ServerRequestInterface $request,
        protected string $message = "%{placeholder}は[{extensions}]拡張子のみが利用可能です。",
        protected array $contexts = []
    ) {
        $this->contexts["extensions"] = implode(",", $extensions);
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        $files = $this->request->getUploadedFiles();
        $file = $files[$this->name] ?? null;
        if (!$file) {
            return true;
        }
        $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
        return in_array($ext, $this->extensions);
    }
}
