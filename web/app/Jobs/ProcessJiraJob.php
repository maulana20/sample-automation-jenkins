<?php

namespace App\Jobs;

use function collect;
use function dispatch;
use function event;

use Spatie\GitHubWebhooks\Exceptions\JobClassDoesNotExist;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessJiraJob extends ProcessWebhookJob
{
    public WebhookCall $webhookCall;

    public function handle()
    {
        event("jira-webhook::{$this->webhookCall->payload['webhookEvent']}", $this->webhookCall);
        event("jira-webhook::{$this->webhookCall->payload['issue_event_type_name']}", $this->webhookCall);

        collect(config("jira-webhook.jobs"))
            ->filter(function (string $jobClassName, $eventActionName) {
                if ($eventActionName === '*') {
                    return true;
                }

                return in_array($eventActionName, [
                    $this->webhookCall->payload['webhookEvent'],
                    $this->webhookCall->payload['issue_event_type_name'],
                ]);
            })
            ->each(function (string $jobClassName) {
                if (! class_exists($jobClassName)) {
                    throw JobClassDoesNotExist::make($jobClassName);
                }
            })
            ->each(fn (string $jobClassName) => dispatch(new $jobClassName($this->webhookCall)));
    }
}