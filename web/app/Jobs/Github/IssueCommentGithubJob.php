<?php

namespace App\Jobs\Github;

class IssueCommentGithubJob extends BaseGithubJob
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