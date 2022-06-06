<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\interfaces;

interface SessionInterface
{
    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, mixed $default=null): mixed;

    /**
     * @return array
     */
    public function getStorage(): array;

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, mixed $value): void;

    /**
     * @param string $name
     * @return void
     */
    public function unset(string $name): void;

    /**
     * @return void
     */
    public function clear(): void;

    /**
     * @param string $name
     * @return boolean
     */
    public function has(string $name): bool;
}