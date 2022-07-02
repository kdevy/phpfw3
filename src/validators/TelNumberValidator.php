<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * 電話番号かどうか
 */
class TelNumberValidator extends Validator
{
    /**
     * @param boolean $with_hyphen
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected bool $with_hyphen = false,
        protected string $message = "%{placeholder}を電話番号形式で入力してください。",
        protected array $contexts = []
    ) {
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        if ($this->with_hyphen) {
            return preg_match('/^0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}\z/', $value);
        } else {
            return preg_match('/^0[0-9]{9,10}\z/', $value);
        }
    }
}
