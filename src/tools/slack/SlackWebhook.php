<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\tools\slack;

use InvalidArgumentException;

class SlackWebhook
{
    /**
     * @param string $webhook_url
     * @param string $env_varname
     */
    public function __construct(
        private string $webhook_url="",
        private string $env_varname="SLACK_WEBHOOK_URL"
    )
    {
        if (!$this->webhook_url && getenv($this->env_varname)) {
            $this->webhook_url = getenv($this->env_varname);
        }

        if (!$this->webhook_url) {
            throw new InvalidArgumentException("The was passed empty webhook url.");
        }
    }

    /**
     * @param SlackWebhookPayload $payload
     * @return void
     */
    public function sent(SlackWebhookPayload $payload): void
    {
        $json = $payload->encodeJson();

        $ch = curl_init();
        $options = [
            CURLOPT_URL => $this->webhook_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'payload' => json_encode($json)
            ])
        ];
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);
    }
}