<?php

namespace App\Providers;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GithubWebhookServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('github-webhook')
            ->hasConfigFile()
            ->hasMigration('create_github_webhook_calls_table');
    }
}