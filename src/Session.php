<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Framework\interfaces\SessionInterface;

class Session implements SessionInterface
{
    /**
     * @var array
     */
    private array $storage = [];
    
    /**
     * @param array $storage
     */
    public function __construct()
    {   
        $this->storage = &$_SESSION ?? [];  // TODO
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name, mixed $default=null): mixed
    {
        if ($this->has($name)) {
            return $this->storage[$name];
        }

        return $default;
    }

    /**
     * @return array
     */
    public function getStorage(): array
    {
        return $this->storage;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, mixed $value): void
    {
        $this->storage[$name] = $value;
    }

    /**
     * @param string $name
     * @return void
     */
    public function unset(string $name): void
    {
        if ($this->has($name)) {
            unset($this->storage[$name]);
        }
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->storage = [];
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->storage);
    }
}