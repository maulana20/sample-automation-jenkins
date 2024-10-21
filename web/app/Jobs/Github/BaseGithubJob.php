<?php

namespace App\Jobs\Github;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use App\Traits\MessageableTrait;

class BaseGithubJob implements ShouldQueue
{
    use Queueable, MessageableTrait;

    protected $event;
    protected $payload;

    protected $to;
    protected $message;

    public function __construct(GithubWebhookCall $webhookCall)
    {
        $this->event   = $webhookCall->eventActionName();
        $this->payload = json_decode($webhookCall->payload["payload"]);
    }

    public function handle(): void
    {
        \Log::info($this->event, [
            "to"      => $this->to,
            "message" => $this->message
        ]);
    }
}