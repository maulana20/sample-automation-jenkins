<?php

namespace App\Configs;

use Spatie\GitHubWebhooks\GitHubSignatureValidator;

class GithubConfig
{
    public function __invoke() : array
    {
        return [
            'name'                  => 'GitHub',
            'signing_secret'        => config('github-webhook.signing_secret'),
            'signature_header_name' => 'X-Hub-Signature-256',
            'signature_validator'   => GitHubSignatureValidator::class,
            'webhook_profile'       => config('github-webhook.profile'),
            'webhook_model'         => config('github-webhook.model'),
            'process_webhook_job'   => config('github-webhook.job'),
            'store_headers' => [
                'X-GitHub-Event',
                'X-GitHub-Delivery',
            ],
        ];
    }
}