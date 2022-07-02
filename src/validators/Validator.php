<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */
declare(strict_types=1);

namespace Framework\validators;

use Framework\exceptions\ValidatorError;

class Validator extends BaseValidator
{
    /**
     * @var string
     */
    protected string $message;

    /**
     * @var array
     */
    protected array $contexts;

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @inheritDoc
     */
    public function getContexts(): array
    {
        return $this->contexts;
    }

    /**
     * @inheritDoc
     */
    public function setContexts(array $contexts): void
    {
        $this->contexts = $contexts;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(mixed $value, array $contexts = []): bool
    {
        if (!$this->validate($value)) {
            throw new ValidatorError(format($this->getMessage(), array_merge($this->getContexts(), $contexts)));
        }
        return true;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    public function validate(mixed $value): bool
    {
        // your override.
        return true;
    }
}
