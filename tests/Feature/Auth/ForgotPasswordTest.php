<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGuestMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('password.forgot'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('password.forgot'))
            ->assertStatus(Response::HTTP_OK);
    }

    public function testForgotPasswordFails(): void
    {
        Notification::fake();

        $data['email'] = $this->faker->email;
        $this->post(route('password.forgot'), $data);

        Notification::assertNothingSent();
    }

    public function testForgotPassword(): void
    {
        Notification::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $data['email'] = $user->email;
        $this->post(route('password.forgot'), $data);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
