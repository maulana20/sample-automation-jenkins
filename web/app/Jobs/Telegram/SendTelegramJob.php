<?php

namespace App\Jobs\Telegram;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Traits\MessageableTrait;

class SendTelegramJob implements ShouldQueue
{
    use Queueable, MessageableTrait;

    protected $event;
    protected $payload;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->event   = $webhookCall->payload["webhookEvent"];
        $this->payload = $webhookCall->payload;
    }

    public function handle(): void
    {
        $to      = $this->payload["user"]["name"];
        $message = $this->getMessage($this->event, [
            "user"    => $this->payload["user"]["name"],
        ]);
        \Log::info($this->event, [
            "to"      => $to,
            "message" => $message
        ]);
    }
}