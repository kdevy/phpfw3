<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework;

use Framework\interfaces\RouteInterface;
use Framework\interfaces\TemplateResponderInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class TemplateResponder implements TemplateResponderInterface
{
    /**
     * @var ServerRequestInterface
     */
    private ServerRequestInterface $request;

    /**
     * @var string
     */
    private string $basePath;

    /**
     * @var null|string
     */
    private ?string $extendFilePath = null;

    const PARTS_START_STR = "<!--##";

    const PARTS_END_STR = "-->";

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
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
     * @return string
     */
    public function getExtendFilePath(): string
    {
        return $this->extendFilePath;
    }

    /**
     * @param string $extendFilePath
     * @return void
     */
    public function setExtendFilePath(string $extendFilePath): void
    {
        $this->extendFilePath = $extendFilePath;
    }

    /**
     * @param integer $statusCode
     * @param array $headers
     * @param string $body
     * @return ResponseInterface
     */
    public function responseFromBody(string $body, $statusCode = 200, array $headers = []): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $resonse = $psr17Factory->createResponse($statusCode);
        $stream = $psr17Factory->createStream($body);
        $resonse = $resonse->withBody($stream);

        foreach ($headers as $key => $value) {
            $resonse = $resonse->withHeader($key, $value);
        }
        if (!$resonse->hasHeader("Content-Type")) {
            $resonse = $resonse->withAddedHeader("Content-Type", "text/html;");
        }

        return $resonse;
    }

    /**
     * @param array $contexts
     * @param integer $statusCode
     * @param array $headers
     * @return ResponseInterface
     */
    public function response(array $contexts = [], int $statusCode = 200, array $headers = []): ResponseInterface
    {
        /** @var RouteInterface */
        $route = $this->request->getAttribute(RouteInterface::class);
        $templatePath = realpath($this->basePath . DS . $route->getModuleName() . DS . $route->getActionName() . ".html");

        if (!is_readable($templatePath)) {
            throw new RuntimeException("Template file not unreadable ({$templatePath}).");
        }

        if ($this->extendFilePath) {
            $parts = self::extractParts(file_get_contents($templatePath));
            $body = file_get_contents(realpath($this->basePath . DS . $this->extendFilePath));
            $body = self::assginContexts($body, $parts);
        } else {
            $body = file_get_contents($templatePath);
        }

        $body = self::assginContexts($body, $contexts);

        return $this->responseFromBody($body, $statusCode, $headers);
    }

    /**
     * @param string $buff
     * @param array $contexts
     * @return string
     */
    public static function assginContexts(string $buff, array $contexts = []): string
    {
        if (!$contexts) {
            return $buff;
        }

        $match_contexts = [];
        preg_match_all("/\___.+?\___/", $buff, $match_contexts);

        foreach ($match_contexts[0] as $match_context) {
            $keyword = str_replace("___", "", $match_context);

            if ($keyword == "") {
                continue;
            }
            if (array_key_exists($keyword, $contexts)) {
                $buff = str_replace([$match_context], $contexts[$keyword], $buff);
            } else {
                $buff = str_replace([$match_context], "", $buff);
            }
        }

        return $buff;
    }

    /**
     * @param string $buff
     * @return array
     */
    public static function extractParts(string $buff): array
    {
        $result = [];

        $buff_arr = explode("\n", $buff);
        $tmp_keyword = null;

        foreach ($buff_arr as $row) {
            $is_deli = strpos($row, self::PARTS_START_STR) !== false;
            if ($is_deli) {
                $keyword = trim(str_replace([self::PARTS_START_STR, self::PARTS_END_STR], "", $row));
                if ($tmp_keyword) {
                    if ($keyword && $keyword == $tmp_keyword) {
                        // block end
                        $tmp_keyword = null;
                    }
                } else {
                    if ($keyword) {
                        // block start
                        $tmp_keyword = $keyword;
                        $result[$tmp_keyword] = [];
                    }
                }
            }

            // line start
            if (!$is_deli && $tmp_keyword) {
                $result[$tmp_keyword][] = $row;
            }
        }

        foreach ($result as $k => $v) {
            $result[$k] = implode("\n", $v);
        }

        return $result;
    }
}