<?php

namespace App\Jobs;

class GithubWebhookPullRequestJob extends GithubWebhookBaseJob
{
    public function handle(): void
    {
        $this->to      = $this->payload->repository->owner->login;
        $this->message = $this->getMessage($this->event, [
            "user"    => $this->payload->pull_request->user->login,
            "message" => $this->payload->pull_request->title,
        ]);
        parent::handle();
    }
}