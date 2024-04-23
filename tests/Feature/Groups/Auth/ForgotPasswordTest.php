<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('password.forgot'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('password.forgot'))
            ->assertOk();
    }

    public function testForgotPasswordFails(): void
    {
        Notification::fake();

        $data['email'] = 'foo@example.com';
        $this->post(route('password.forgot'), $data);

        Notification::assertNothingSent();
    }

    public function testForgotPassword(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $data['email'] = $user->email;
        $this->post(route('password.forgot'), $data);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
