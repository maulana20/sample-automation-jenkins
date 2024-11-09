<?php

namespace App\Jobs;

use function collect;
use function dispatch;
use function event;

use Spatie\GitHubWebhooks\Exceptions\JobClassDoesNotExist;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Enums\ProviderEnum;
use App\Helpers\WebhookHelper;

class ProcessClientJob extends ProcessWebhookJob
{
    public WebhookCall $webhookCall;
    protected array $config;

    public function handle()
    {
        $this->config = (new WebhookHelper)->config($this->webhookCall->name);
        return ProviderEnum::JIRA === $this->webhookCall->name
            ? $this->handleJira()
            : $this->handleCustom();
    }

    public function handleJira()
    {
        event("jira-webhook::{$this->webhookCall->payload['webhookEvent']}", $this->webhookCall);
        event("jira-webhook::{$this->webhookCall->payload['issue_event_type_name']}", $this->webhookCall);
        collect(config("jira-webhook.jobs"))
            ->filter(function (string $jobClassName, $eventActionName) {
                if ($eventActionName === '*') return true;
                return in_array($eventActionName, [ $this->webhookCall->payload['webhookEvent'], $this->webhookCall->payload['issue_event_type_name'] ]);
            })
            ->each(function (string $jobClassName) {
                if (!class_exists($jobClassName)) throw JobClassDoesNotExist::make($jobClassName);
            })
            ->each(fn (string $jobClassName) => dispatch(new $jobClassName($this->webhookCall)));
    }

    public function handleCustom()
    {
        event("{$this->config['name']}-webhook::send", $this->webhookCall);
        dispatch(new $this->config["jobs"]["send"]($this->webhookCall));
    }
}