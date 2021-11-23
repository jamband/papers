<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
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

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testEmailVerificationNotificationFails(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertNothingSent();
    }

    public function testEmailVerificationNotification(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
