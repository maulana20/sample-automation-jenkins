<?php

namespace Tests\TestClasses;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class HandlePingJiraJob implements ShouldQueue
{
    public function __construct(WebhookCall $webhookCall)
    {}

    public function handle(): void
    {}
}
