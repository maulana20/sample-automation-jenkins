<?php

return [
    'name'                  => "Jira",
    'signing_secret'        => "",
    'signature_header_name' => 'X-Hub-Signature-256',
    'signature_validator'   => \Spatie\GitHubWebhooks\GitHubSignatureValidator::class,
    'webhook_profile'       => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
    'webhook_model'         => \Spatie\GitHubWebhooks\Models\GitHubWebhookCall::class,
    'process_webhook_job'   => \App\Jobs\ProcessJiraJob::class,
    // additional
    "jobs" => [
        "ping" => \App\Jobs\Jira\PingJiraJob::class,
    ]
];