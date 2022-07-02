<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 数字の下限値チェック
 */
class NumberMinValidator extends Validator
{
    /**
     * @param int $min
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $min,
        protected string $message = "%{placeholder}を{min}以上で入力してください。",
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
        return $value >= $this->min;
    }
}
