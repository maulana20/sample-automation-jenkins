<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidWebhookSignature;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProcessor;
use Symfony\Component\HttpFoundation\Response;
use App\Configs\BaseConfig;

class WebhookController
{
    public function __invoke(Request $request, $provider)
    {
        $webhookConfig = new WebhookConfig(BaseConfig::provider($provider));
        try {
            (new WebhookProcessor($request, $webhookConfig))->process();
        } catch (InvalidWebhookSignature $e) {
            return response()->json(['message' => 'invalid signature'], Response::HTTP_FORBIDDEN);
        }
        return response()->json(['message' => 'ok']);
    }
}