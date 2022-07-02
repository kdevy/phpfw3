<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

/**
 * パスワードポリシーチェック
 */
class PasswordValidator extends Validator
{
    /**
     * @param integer $min
     * @param integer $max
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected int $min = 8,
        protected int $max = 20,
        protected string $message = "%{placeholder}を{min}文字以上{max}文字未満の数字、英大文字、英子文字、記号（!\"#$%&'()*+,-./:;<=>?@[]^_`{|}~）の文字種それぞれを最低１文字含むようにして下さい。",
        protected array $contexts = []
    ) {
        $this->contexts["min"] = $min;
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
        if (
            preg_match('/^(?=.*[A-Z]).+$/', $value)
            && preg_match('/^(?=.*[a-z]).+$/', $value)
            && preg_match('/^(?=.*[0-9]).+$/', $value)
            && preg_match('/^(?=.*[!"#\$%&\'\(\)\*\+,-\.\/:;<=>\?@\[\]\^_`\{\|\}~]).+$/', $value)
            && preg_match('/^(?!.*[^a-zA-Z0-9!"#\$%&\'\(\)\*\+,-\.\/:;<=>\?@\[\]\^_`\{\|\}~]).+$/', $value)
            && (strlen($value) >= $this->min && strlen($value) < $this->max)
        ) {
            return true;
        }
        return false;
    }
}
