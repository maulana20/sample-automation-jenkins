<?php

namespace App\Traits;

trait MessageableTrait
{
    protected $messageable = [
        "ping"                  => "{user} has ping",
        "push"                  => "{user} has push commit {message}",
        "pull_request.opened"   => "{user} create new PR {message}",
        "issue_comment.created" => "{user} has comment {message}"
    ];

    public function getMessage($event, $params) : string
    {
        return strtr($this->messageable[$event], array_combine(array_map(fn ($key) => "{" . $key . "}", array_keys($params)), array_values($params)));
    }
}