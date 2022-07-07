<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\tools\slack;

class SlackWebhookPayload
{
    /**
     * @param string $text
     * @param string|null $channel
     * @param string|null $username
     * @param array $attachments
     */
    public function __construct(
        protected string $text,
        protected ?string $channel=null,
        protected ?string $username=null,
        protected array $attachments=[]
    )
    {
    }

    /**
     * @param string $channel
     * @return void
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param array $params
     * @return void
     */
    public function addAttachment(array $params): void
    {
        $this->attachments[] = $params;
    }

    /**
     * @return string
     */
    public function encodeJson(): string
    {
        $json = [
            "text" => $this->text,
        ];
        if ($this->channel) $json["channel"] = $this->channel;
        if ($this->username) $json["username"] = $this->username;
        if ($this->attachments) $json["attachments"] = $this->attachments;

        return json_encode($json);
    }
}