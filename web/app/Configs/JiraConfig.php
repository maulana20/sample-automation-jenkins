<?php

namespace App\Configs;

use Spatie\GitHubWebhooks\GitHubSignatureValidator;

class JiraConfig
{
    public function __invoke() : array
    {
        return [
            'name'                  => 'Jira',
            'signing_secret'        => config('jira-webhook.signing_secret'),
            'signature_header_name' => 'X-Hub-Signature-256',
            'signature_validator'   => GitHubSignatureValidator::class,
            'webhook_profile'       => config('jira-webhook.profile'),
            'webhook_model'         => config('jira-webhook.model'),
            'process_webhook_job'   => config('jira-webhook.job'),
            'store_headers' => [
                'X-Jira-Event',
                'X-Jira-Delivery',
            ],
        ];
    }
}
