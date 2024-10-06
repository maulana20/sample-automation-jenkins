<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;

class GithubWebhookPushJob implements ShouldQueue
{
    use Queueable;
    
    protected $githubWebhook;

    public function __construct(GithubWebhookCall $githubWebhook)
    {
        $this->githubWebhook = $githubWebhook;
    }

    public function handle(): void
    {
        \Log::info($this->githubWebhook->eventActionName(), $this->githubWebhook->payload);
    }
}
