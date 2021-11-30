<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

define("APP_START_TIME", microtime(true));

define("DS", DIRECTORY_SEPARATOR);

require_once __DIR__ . DS . "vendor" . DS . "autoload.php";

/**
 * @var Application
 */
$app = require_once __DIR__ . DS . "app" . DS . "app.php";
$app->run();
