<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

define("IS_CLI", php_sapi_name() == "cli");

/**
 * アプリケーション固有の定義を行います。
 */

define("BASE_DIR", dirname(dirname(__DIR__)));

define("APP_DIR", BASE_DIR . DS . "app");

define("INCLUDE_DIR", APP_DIR . DS . "includes");

define("VAR_DIR", BASE_DIR . DS . "var");

define("LOG_DIR", VAR_DIR . DS . "logs");

define("APACHE_LOG_DIR", LOG_DIR . DS . "httpd");

define("APP_LOG_DIR", LOG_DIR . DS . "app");

define("SESSION_SAVE_DIR", VAR_DIR . DS . "session");

define("UPLOAD_DIR", BASE_DIR . DS . "uploads");

define("DEBUG", true);

/**
 * php ini settings
 */

ini_set('display_errors', "On");

ini_set('log_errors','On');

ini_set("error_log", APACHE_LOG_DIR . DS . "php_error_log");

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

date_default_timezone_set("Asia/Tokyo");

ini_set("default_charset", "UTF-8");

ini_set("mbstring.language", "Japanese");

ini_set("upload_max_filesize", "128M");
ini_set("post_max_size", "128M");
ini_set("memory_limit", "256M");
ini_set("max_file_uploads", "99");

/**
 * 任意の定数・関数定義ファイルを読み込んで下さい。
 */
requireOnceFrom([
    __DIR__ . DS . "*.php",
]);
