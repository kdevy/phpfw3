<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 全角半角の文字数上限値チェック
 */
class StrLengthMaxWidthValidator extends Validator
{
    /**
     * @param int $max
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $max,
        protected string $message = "%{placeholder}を{max}文字以下で入力してください（半角0.5／全角1）。",
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
        return (mb_strwidth($value) / 2) <= $this->max;
    }
}
