<?php

namespace App\Jobs\Jira;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Traits\MessageableTrait;

class BaseJiraJob implements ShouldQueue
{
    use Queueable, MessageableTrait;

    protected $event;
    protected $payload;

    protected $to;
    protected $message;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->event   = $webhookCall->payload["webhookEvent"];
        $this->payload = $webhookCall->payload;
    }

    public function handle(): void
    {
        \Log::info($this->event, [
            "to"      => $this->to,
            "message" => $this->message
        ]);
    }
}