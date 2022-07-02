<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * IPv4形式かどうか
 */
class IPv4Validator extends Validator
{
    /**
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $message = "%{placeholder}をIPv4アドレス形式で入力してください。",
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
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}
