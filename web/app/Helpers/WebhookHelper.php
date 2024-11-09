<?php

namespace App\Helpers;

use App\Enums\ProviderEnum;

class WebhookHelper
{
    public function config($provider)
    {
        switch ($provider) {
            case ProviderEnum::GITHUB   : return $this->configGithub();
            case ProviderEnum::JIRA     : return config("jira-webhook");
            case ProviderEnum::TELEGRAM : return config("telegram-webhook");
            default                     : throw new \Exception("provider not exists");
        }
    }

    protected function configGithub()
    {
        return [
            'name'                  => ProviderEnum::GITHUB,
            'signing_secret'        => config('github-webhook.signing_secret'),
            'signature_header_name' => 'X-Hub-Signature-256',
            'signature_validator'   => \Spatie\GitHubWebhooks\GitHubSignatureValidator::class,
            'webhook_profile'       => config('github-webhook.profile'),
            'webhook_model'         => config('github-webhook.model'),
            'process_webhook_job'   => config('github-webhook.job'),
            'store_headers'         => [
                'X-GitHub-Event',
                'X-GitHub-Delivery',
            ],
        ];
    }
}