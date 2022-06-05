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

define("VAR_DIR", BASE_DIR . DS . "var");

define("LOG_DIR", VAR_DIR . DS . "logs");

define("APACHE_LOG_DIR", LOG_DIR . DS . "httpd");

define("APP_LOG_DIR", LOG_DIR . DS . "app");

define("DEBUG", true);

/**
 * php ini settings
 */

ini_set('display_errors', "On");

ini_set('log_errors','On');

ini_set("error_log", APACHE_LOG_DIR . DS . "php_error_log");

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

/**
 * 任意の定数・関数定義ファイルを読み込んで下さい。
 */
requireOnceFrom([
    __DIR__ . DS . "*.php",
    // __DIR__ . DS . "functions/*.php",
    // __DIR__ . DS . "constants/*.php",
]);
