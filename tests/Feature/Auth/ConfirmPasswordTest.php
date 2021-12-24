<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\ConfirmPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see ConfirmPassword */
class ConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthMiddleware(): void
    {
        $this->get(route('password.confirm'))
            ->assertRedirect(route('auth.login'));

        $this->post(route('password.confirm'))
            ->assertRedirect(route('auth.login'));
    }

    public function testThrottleMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('password.confirm'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('password.confirm'))
            ->assertOk();
    }

    public function testConfirmPasswordFails(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $data['password'] = 'wrong_password';

        $this->actingAs($user)
            ->post(route('password.confirm'), $data)
            ->assertSessionHasErrors();
    }

    public function testConfirmPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $data['password'] = 'password';

        $this->actingAs($user)
            ->post(route('password.confirm'), $data)
            ->assertSessionHasNoErrors();
    }
}
