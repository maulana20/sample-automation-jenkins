<?php

namespace App\Jobs\Github;

class PushGithubJob extends BaseGithubJob
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