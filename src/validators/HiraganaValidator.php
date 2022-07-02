<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * ひらがなのみかどうか
 */
class HiraganaValidator extends Validator
{
    /**
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $message = "%{placeholder}をひらがなで入力してください。",
        protected array $contexts = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        return preg_match('/[^ぁ-んー]/u', $value);
    }
}
