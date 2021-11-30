<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

/**
 * アプリケーション固有の定義を行います。
 */

define("BASE_DIR", dirname(dirname(__DIR__)));

define("APP_DIR", BASE_DIR . DS . "app");

define("DEBUG", true);

/**
 * 任意の定数・関数定義ファイルを読み込んで下さい。
 */
requireOnceFrom([
    __DIR__ . DS . "*.php",
    // __DIR__ . DS . "functions/*.php",
    // __DIR__ . DS . "constants/*.php",
]);
