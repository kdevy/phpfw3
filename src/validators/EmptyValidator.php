<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 空でないかどうか
 */
class EmptyValidator extends Validator
{
    /**
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $message = "%{placeholder}を入力してください。",
        protected array $contexts = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        return (bool)$value;
    }
}
