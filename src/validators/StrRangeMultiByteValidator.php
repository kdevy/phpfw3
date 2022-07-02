<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 全角の文字数範囲チェック
 */
class StrRangeMultiByteValidator extends Validator
{
    /**
     * @param int $min
     * @param int $max
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $min,
        protected int $max,
        protected string $message = "%{placeholder}を全角で{min}文字以上{max}文字以下で入力してください。",
        protected array $contexts = []
    ) {
        $this->contexts["min"] = $min;
        $this->contexts["max"] = $max;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        $length = mb_strlen($value);
        return $length >= $this->min && $length <= $this->max;
    }
}
