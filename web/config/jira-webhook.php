<?php

use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

return [
    'signing_secret' => env('JIRA_WEBHOOK_SECRET'),
    'jobs' => [
        'ping' => \App\Jobs\Jira\PingJiraJob::class,
    ],
    'model' => GitHubWebhookCall::class,
    'prune_webhook_calls_after_days' => 10,
    'job' => \App\Jobs\ProcessJiraJob::class,
    'profile' => ProcessEverythingWebhookProfile::class,
    'verify_signature' => env('JIRA_SIGNATURE_VERIFY', true),
];
