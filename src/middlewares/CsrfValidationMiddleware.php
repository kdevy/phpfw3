<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\middlewares;

use \RuntimeException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CsrfValidationMiddleware implements MiddlewareInterface
{
    public const HASH_ALGO = "sha256";
    public const CSRF_INPUT_NAME = "_csrf";

    /**
     * @return string
     */
    public static function generateToken(): string
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            throw new \BadMethodCallException('セッションがアクティブではありません。');
        }
        return hash(self::HASH_ALGO, session_id());
    }

    /**
     * @return string
     */
    public static function generateTag(): string
    {
        $token = self::generateToken();
        return "<input name=" . self::CSRF_INPUT_NAME . " type=hidden id=id_" . self::CSRF_INPUT_NAME . " value={$token}>";
    }

    /**
     * @param string|null $token
     * @return boolean
     */
    public static function validate(?string $token): bool
    {
        return isset($token) && self::generateToken() === $token;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $server = $request->getServerParams();
        $method = $server["REQUEST_METHOD"];
        $input_token = $request->getParsedBody()[self::CSRF_INPUT_NAME] ?? null;

        if (!in_array($method, ["GET", "HEAD", "OPTIONS", "TRACE"])) {
            if (!self::validate($input_token)) {
                throw new RuntimeException('アンチCSRFトークンの検証に失敗しました。');
            }
        }

        $contexts = [
            "csrf_token" => self::generateToken(),
            "csrf_tag" => self::generateTag(),
        ];
        $request = $request->withAttribute(ContextsSettingsMiddleware::ATTRIBUTE_NAME, $contexts);
        $response = $handler->handle($request);

        return $response;
    }
}
