<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private UrlGenerator $url;
    private VerifyEmail $verifyEmail;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
        $this->verifyEmail = $this->app->make(VerifyEmail::class);
    }

    public function testAuthMiddleware(): void
    {
        $this->post($this->url->route('verification.send'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testThrottleMiddleware(): void
    {
        Notification::fake();

        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('verification.send'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testEmailVerificationNotificationFails(): void
    {
        Notification::fake();

        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('verification.send'))
            ->assertRedirect($this->url->route('home'));

        Notification::assertNothingSent();
    }

    public function testEmailVerificationNotification(): void
    {
        Notification::fake();

        $user = $this->userFactory
            ->unverified()
            ->makeOne();

        $this->actingAs($user)
            ->post($this->url->route('verification.send'))
            ->assertRedirect($this->url->route('home'));

        Notification::assertSentTo($user, $this->verifyEmail::class);
    }
}
