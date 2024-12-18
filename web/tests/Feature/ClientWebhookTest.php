<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Spatie\GitHubWebhooks\Models\GitHubWebhookCall;

use Faker\Factory;
use Faker\Provider\Internet;
use Tests\TestCase;
use Tests\TestClasses\HandlePingJiraJob;
use Tests\TestClasses\HandleSendTelegramJob;

use App\Http\Controllers\WebhookController;

class ClientWebhookTest extends TestCase
{
    use DatabaseTransactions;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        Route::post("api/{provider}/webhook", WebhookController::class);
        Bus::fake([ HandlePingJiraJob::class, HandleSendTelegramJob::class ]);
        $this->faker = Factory::create();
        $this->faker->addProvider(new Internet($this->faker));
    }

    public function test_ping_payload_webhook_jira()
    {
        config()->set("jira-webhook.jobs", [ "ping" => HandlePingJiraJob::class ]);
        $payload = [
            "timestamp" => $this->faker->unixTime,
            "webhookEvent" => "ping",
            "issue_event_type_name" => "pingx",
            "user" => [
                "self" => $this->faker->url,
                "name" => $this->faker->userName
            ]
        ];

        $this->postJson("api/jira/webhook", $payload)
            ->assertSuccessful();

        Bus::assertDispatched(HandlePingJiraJob::class);
        $this->assertEquals($payload, GitHubWebhookCall::latest()->first()->payload);
    }

    public function test_ping_event_webhook_jira()
    {
        Event::fake();

        $payload = [
            "timestamp" => $this->faker->unixTime,
            "webhookEvent" => "ping",
            "issue_event_type_name" => "pingx",
            "user" => [
                "self" => $this->faker->url,
                "name" => $this->faker->userName
            ]
        ];

        $this->postJson("api/jira/webhook", $payload)
            ->assertSuccessful();

        Event::assertDispatched("jira-webhook::ping", 1);
    }

    public function test_send_payload_webhook_telegram()
    {
        config()->set("telegram-webhook.jobs", [ "send" => HandleSendTelegramJob::class ]);
        $payload = [
            "timestamp" => $this->faker->unixTime,
            "webhookEvent" => "ping",
            "issue_event_type_name" => "pingx",
            "user" => [
                "self" => $this->faker->url,
                "name" => $this->faker->userName
            ]
        ];

        $this->postJson("api/telegram/webhook", $payload)
            ->assertSuccessful();

        Bus::assertDispatched(HandleSendTelegramJob::class);
        $this->assertEquals($payload, GitHubWebhookCall::latest()->first()->payload);
    }

    public function test_send_event_webhook_telegram()
    {
        Event::fake();

        $payload = [
            "timestamp" => $this->faker->unixTime,
            "webhookEvent" => "ping",
            "issue_event_type_name" => "pingx",
            "user" => [
                "self" => $this->faker->url,
                "name" => $this->faker->userName
            ]
        ];

        $this->postJson("api/telegram/webhook", $payload)
            ->assertSuccessful();

        Event::assertDispatched("telegram-webhook::send", 1);
    }
}