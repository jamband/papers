<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthMiddleware(): void
    {
        $this->post(route('auth.logout'))
            ->assertRedirect(route('auth.login'));
    }

    public function testLogout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('auth.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
