<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

use \DateTime;

/**
 * DateTimeフォーマット通りかどうか
 */
class DateTimeValidator extends Validator
{
    /**
     * @param string $format
     * @param string $message
     * @param array $contexts
     */
    public function __construct(
        protected string $format = "Y/m/d H:i:s",
        protected string $message = "%{placeholder}を日付形式（{format}）で入力してください。",
        protected array $contexts = []
    ) {
        $this->contexts["format"] = $format;
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value): bool
    {
        if (!$value) {
            return true;
        }
        $date = DateTime::createFromFormat($this->format, $value);
        return $date && $date->format($value) == $value;
    }
}
