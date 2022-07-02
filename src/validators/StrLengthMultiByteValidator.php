<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 全角の文字数チェック
 */
class StrLengthMultiByteValidator extends Validator
{
    /**
     * @param int $length
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $length,
        protected string $message = "%{placeholder}を全角{length}文字で入力してください。",
        protected array $contexts = []
    ) {
        $this->contexts["length"] = $length;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        return mb_strlen($value) == $this->length;
    }
}
