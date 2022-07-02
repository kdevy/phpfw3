<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * メールアドレス形式かどうか
 */
class EMailAddressValidator extends Validator
{
    /**
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $message = "%{placeholder}をメールアドレス形式で入力してください。",
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
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        if (strpos($value, '@docomo.ne.jp') !== false || strpos($value, '@ezweb.ne.jp') !== false) {
            $pattern = '/^([a-zA-Z])+([a-zA-Z0-9\._-])*@(docomo\.ne\.jp|ezweb\.ne\.jp)$/';
            if (preg_match($pattern, $value, $matches) === 1) {
                return true;
            }
        }

        return false;
    }
}
