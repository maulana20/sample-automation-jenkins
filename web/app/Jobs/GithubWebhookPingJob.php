<?php

namespace App\Jobs;

class GithubWebhookPingJob extends GithubWebhookBaseJob
{
    public function handle(): void
    {
        $this->to      = $this->payload->repository->owner->login;
        $this->message = $this->getMessage($this->event, [
            "user"    => $this->payload->repository->owner->login,
        ]);
        parent::handle();
    }
}
