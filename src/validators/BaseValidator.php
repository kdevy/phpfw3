<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

abstract class BaseValidator
{
    /**
     * @return string
     */
    abstract public function getMessage(): string;

    /**
     * @param string $message
     * @return void
     */
    abstract public function setMessage(string $message): void;

    /**
     * @return array
     */
    abstract public function getContexts(): array;

    /**
     * @param array $contexts
     * @return void
     */
    abstract public function setContexts(array $contexts): void;

    /**
     * @param mixed $value
     * @param array $contexts
     * @return boolean
     * @throws ValidatorError
     */
    abstract public function __invoke(mixed $value, array $contexts = []): bool;
}
