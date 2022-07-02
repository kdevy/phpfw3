<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 全角半角の文字数下限値チェック
 */
class StrLengthMinWidthValidator extends Validator
{
    /**
     * @param int $min
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $min,
        protected string $message = "%{placeholder}を{min}文字以上で入力してください（半角0.5／全角1）。",
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
        return (mb_strwidth($value) / 2) >= $this->min;
    }
}
