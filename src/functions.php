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
