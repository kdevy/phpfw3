<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

/**
 * @param array $patterns
 * @return void
 */
function requireOnceFrom(array $patterns): void
{
    foreach ($patterns as $pattern) {
        foreach (glob($pattern) as $file) {
            require_once $file;
        }
    }
}

/**
 * @param string $str
 * @param [type] ...$replacements
 * @return string
 */
function format(string $str, ...$replacements): string
{
    array_walk($replacements, function ($replacement) use (&$str) {
        $replacement = array_combine(
            array_map(fn ($rep_key) => '%{' . $rep_key . '}', array_keys($replacement)),
            array_values($replacement)
        );

        $str = strtr($str, $replacement);
    });

    return $str;
}

/**
 * @param string $filename
 * @return boolean|string
 */
function getMimeType(string $filename): bool|string
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $path = INCLUDE_DIR . DS . "mimetypes.json";
    if (!is_readable($path)) {
        throw new RuntimeException("cannot read file '{$path}'");
    }
    $mimeTypes = (array)json_decode(file_get_contents($path));
    return $mimeTypes[$ext] ?? false;
}
