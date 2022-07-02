<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 英字のみかどうか
 */
class AlphabetValidator extends Validator
{
    /**
     * @param string $message
     */
    public function __construct(
        protected string $message = "%{placeholder}を英字のみで入力してください。",
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
        return ctype_alpha($value);
    }
}
