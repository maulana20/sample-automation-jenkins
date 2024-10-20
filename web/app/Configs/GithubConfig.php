<?php

namespace App\Configs;

use Spatie\GitHubWebhooks\GitHubSignatureValidator;

class GithubConfig
{
    public function __invoke() : array
    {
        return [
            'name'                  => 'GitHub',
            'signing_secret'        => config('github-webhooks.signing_secret'),
            'signature_header_name' => 'X-Hub-Signature-256',
            'signature_validator'   => GitHubSignatureValidator::class,
            'webhook_profile'       => config('github-webhooks.profile'),
            'webhook_model'         => config('github-webhooks.model'),
            'process_webhook_job'   => config('github-webhooks.job'),
            'store_headers' => [
                'X-GitHub-Event',
                'X-GitHub-Delivery',
            ],
        ];
    }
}