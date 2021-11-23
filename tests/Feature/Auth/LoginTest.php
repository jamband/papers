<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('auth.login'))
            ->assertRedirect(route('home'));

        $this->actingAs($user)
            ->post(route('auth.login'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('auth.login'))
            ->assertStatus(Response::HTTP_OK);
    }

    public function testLoginFails(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $data['email'] = $user->email;
        $data['password'] = 'wrong_password';

        $this->post(route('auth.login'), $data);

        $this->assertGuest();
    }

    public function testLogin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $data['email'] = $user->email;
        $data['password'] = 'password';

        $this->post(route('auth.login'), $data)
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }
}
