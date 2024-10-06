<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfTokenCustom extends Middleware
{
    protected $except = [
        "github-webhook"
    ];
}
