<?php

namespace App\Jobs;

class GithubWebhookIssueCommentJob extends GithubWebhookBaseJob
{
    public function handle(): void
    {
        $this->to      = $this->payload->issue->user->login;
        $this->message = $this->getMessage($this->event, [
            "user"    => $this->payload->comment->user->login,
            "message" => $this->payload->comment->body,
        ]);
        parent::handle();
    }
}