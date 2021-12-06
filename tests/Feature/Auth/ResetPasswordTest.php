<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGuestMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('password.reset', ['token' => 'foo']))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get('/reset-password/xxx?'.$this->faker->email)
            ->assertOk();
    }

    public function testResetPasswordFails(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $data['token'] = Str::random(60);
        $data['email'] = $user->email;
        $data['password'] = 'password';
        $data['password_confirmation'] = $data['password'];

        $this->post(route('password.update'), $data)
            ->assertSessionHasErrors();
    }

    public function testResetPassword(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $data['email'] = $user->email;
        $this->post(route('password.forgot'), $data);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $data['token'] = $notification->token;
            $data['email'] = $user->email;
            $data['password'] = 'new_password';
            $data['password_confirmation'] = $data['password'];

            $this->post(route('password.update'), $data)
                ->assertSessionHasNoErrors();

            return true;
        });
    }
}
