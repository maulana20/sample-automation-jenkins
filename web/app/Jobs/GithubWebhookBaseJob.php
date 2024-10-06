<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use App\Traits\MessageableTrait;

class GithubWebhookBaseJob implements ShouldQueue
{
    use Queueable, MessageableTrait;

    protected $githubWebhook;

    protected $event;
    protected $payload;

    protected $to;
    protected $message;

    public function __construct(GithubWebhookCall $githubWebhook)
    {
        $this->githubWebhook = $githubWebhook;
        $this->event         = $githubWebhook->eventActionName();
        $this->payload       = json_decode($githubWebhook->payload["payload"]);
    }

    public function handle(): void
    {
        \Log::info($this->event, [
            "to"      => $this->to,
            "message" => $this->message
        ]);
    }
}