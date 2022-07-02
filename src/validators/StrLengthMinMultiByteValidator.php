<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 全角の文字数下限値チェック
 */
class StrLengthMinMultiByteValidator extends Validator
{
    /**
     * @param int $min
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $min,
        protected string $message = "%{placeholder}を全角{min}文字以上で入力してください。",
        protected array $contexts = []
    ) {
        $this->contexts["min"] = $min;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        return mb_strlen($value) >= $this->min;
    }
}
