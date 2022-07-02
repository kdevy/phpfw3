<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * URLかどうか
 */
class URLValidator extends Validator
{
    /**
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $message = "%{placeholder}をURL形式で入力してください。",
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
        return (filter_var($value, FILTER_VALIDATE_URL) && preg_match('|^https?://.*$|', $value));
    }
}
