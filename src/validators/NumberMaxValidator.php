<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 数字の上限値チェック
 */
class NumberMaxValidator extends Validator
{
    /**
     * @param int $max
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $max,
        protected string $message = "%{placeholder}を{max}以下で入力してください。",
        protected array $contexts = []
    ) {
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
        return $value <= $this->max;
    }
}
