<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthMiddleware(): void
    {
        $this->post(route('verification.send'))
            ->assertRedirect(route('auth.login'));
    }

    public function testThrottleMiddleware(): void
    {
        Notification::fake();

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('verification.send'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testEmailVerificationNotificationFails(): void
    {
        Notification::fake();

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertNothingSent();
    }

    public function testEmailVerificationNotification(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = UserFactory::new()
            ->unverified()
            ->createOne();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
