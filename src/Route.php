<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Framework\interfaces\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;

class Route implements RouteInterface
{
    /**
     * @var string
     */
    private string $moduleName;

    /**
     * @var string
     */
    private string $actionName;

    /**
     * @param string|array|ServerRequestInterface $requestPath
     */
    public function __construct($requestPath)
    {
        list($this->moduleName, $this->actionName) = static::parse($requestPath);
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array
     */
    public function getPath(): array
    {
        return [$this->moduleName, $this->actionName];
    }

    /**
     * @return string
     */
    public function getPathName(): string
    {
        return "/{$this->moduleName}/{$this->actionName}";
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPathName();
    }

    /**
     * @param string|array|ServerRequestInterface $requestPath
     * @return array
     */
    public static function parse($requestPath): array
    {
        $result = $requestPath;
        if ($requestPath instanceof ServerRequestInterface) {
            $result = $requestPath->getUri()->getPath();
        }

        if (is_string($result)) {
            $result = explode("/", explode("?", $result)[0]);
            array_shift($result);
        }

        if (count($result) == 1) {
            $result[1] = (isset($result[0]) && trim($result[0]) !== "" ? $result[0] : "index");
            $result[0] = "index";
        } else {
            $result[0] = (isset($result[0]) && trim($result[0]) !== "" ? $result[0] : "index");
            $result[1] = (isset($result[1]) && trim($result[1]) !== "" ? $result[1] : "index");
        }

        $result[0] = basename($result[0]);
        $result[1] = basename($result[1]);
        return $result;
    }
}