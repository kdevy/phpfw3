<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Framework\exceptions\UnresolvableActionError;
use Framework\interfaces\ActionInterface;
use Framework\interfaces\ActionResolverInterface;
use Framework\interfaces\RouteInterface;
use Framework\interfaces\TemplateResponderInterface;

class ActionResolver implements ActionResolverInterface
{
    /**
     * @var string
     */
    protected string $basePath;

    /**
     * @var TemplateResponderInterface
     */
    protected TemplateResponderInterface $templateResponder;

    /**
     * @param TemplateResponderInterface $templateResponder
     */
    public function __construct(TemplateResponderInterface $templateResponder)
    {
        $this->templateResponder = $templateResponder;
    }

    /**
     * @param string $basePath
     * @return void
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ActionInterface
     */
    public function resolve(ServerRequestInterface $request): ActionInterface
    {
        /**
         * @var RouteInterface $route
         */
        $route = $request->getAttribute(RouteInterface::class);
        $actionClassName = self::camelize($route->getActionName()) . "Action";
        $includePath = $this->basePath . DIRECTORY_SEPARATOR . $route->getModuleName()
            . DIRECTORY_SEPARATOR . $actionClassName . ".php";

        if (!is_readable($includePath)) {
            throw new UnresolvableActionError("The action file cannot be read ({$includePath}).");
        }

        require_once($includePath);

        if (!class_exists($actionClassName)) {
            throw new UnresolvableActionError("The action class that does not exist ({$actionClassName}).");
        }

        /**
         * @var ActionInterface
         */
        $action = new $actionClassName($request, $this->templateResponder);

        return $action;
    }

    /**
     * @param string $str
     * @return string
     */
    static public function camelize(string $str): string
    {
        return str_replace(['-', '_'], '', ucwords($str, ' -_'));
    }
}
