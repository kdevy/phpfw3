<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 正規表現
 */
class RegexValidator extends Validator
{
    /**
     * @param string $pattern
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $pattern,
        protected string $message = "%{placeholder}が正規表現（{pattern}）と一致していません。",
        protected array $contexts = []
    ) {
        $this->contexts["pattern"] = $pattern;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        return preg_match($this->pattern, $value);
    }
}
