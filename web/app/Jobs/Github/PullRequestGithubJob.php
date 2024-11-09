<?php

namespace App\Jobs\Github;

class PullRequestGithubJob extends BaseGithubJob
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