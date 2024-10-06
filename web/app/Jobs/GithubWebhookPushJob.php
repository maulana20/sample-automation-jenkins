<?php

namespace App\Jobs;

class GithubWebhookPushJob extends GithubWebhookBaseJob
{
    public function handle(): void
    {
        $this->to      = $this->payload->repository->owner->login;
        $this->message = $this->getMessage($this->event, [
            "user"    => $this->payload->repository->owner->login,
            "message" => $this->payload->head_commit->message,
        ]);
        parent::handle();
    }
}