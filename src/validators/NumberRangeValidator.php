<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 数字の範囲チェック
 */
class NumberRangeValidator extends Validator
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
        protected string $message = "%{placeholder}を{min}〜{max}の範囲で入力してください。",
        protected array $contexts = []
    ) {
        $this->contexts["max"] = $max;
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
        return $value >= $this->min && $value <= $this->max;
    }
}
