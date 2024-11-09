<?php

namespace App\Jobs\Jira;

class PingJiraJob extends BaseJiraJob
{
    public function handle(): void
    {
        $this->to      = $this->payload["user"]["name"];
        $this->message = $this->getMessage($this->event, [
            "user"    => $this->payload["user"]["name"],
        ]);
        parent::handle();
    }
}
