<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

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

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('password.confirm'))
            ->assertStatus(Response::HTTP_OK);
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
