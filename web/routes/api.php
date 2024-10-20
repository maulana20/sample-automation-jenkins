<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("{provider}/webhook", \App\Http\Controllers\WebhookController::class);
