<?php

/**
 * Kdevy framework - My original second php framework.
 *
 * Copyright © 2021 kdevy. All Rights Reserved.
 */

declare(strict_types=1);

namespace Framework\tools\slack;

class SlackWebhookNotificationPayload extends SlackWebhookPayload
{
    /**
     * @param string $title
     * @param string $message
     * @param string|null $detail
     * @param string|null $url
     * @param string|null $channel
     * @param string|null $username
     * @param array $attachments
     */
    public function __construct(
        protected string $title,
        protected string $message,
        protected ?string $detail = null,
        protected ?string $url = null,
        protected ?string $channel = null,
        protected ?string $username = null,
        protected array $attachments = []
    )
    {
        parent::__construct("", $this->channel, $this->username, $this->attachments);
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
        $now = date("Y/m/d H:i:s e");
        $hostname = gethostname();
        $ip = trim(shell_exec("hostname -I | awk '{print $2}'"));
        $this->text = "{$this->title} - [{$hostname}][{$ip}][{$now}]\n{$this->url}";

        if ($this->detail) $this->attachments[] = ["text" => $this->detail];
        
        return parent::encodeJson();
    }
}