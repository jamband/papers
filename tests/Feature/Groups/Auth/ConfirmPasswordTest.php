<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function testThrottleMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('password.confirm'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testView(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('password.confirm'))
            ->assertOk();
    }

    public function testConfirmPasswordFails(): void
    {
        $data['password'] = 'wrong_password';

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('password.confirm'), $data)
            ->assertSessionHasErrors();
    }

    public function testConfirmPassword(): void
    {
        $data['password'] = 'password';

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('password.confirm'), $data)
            ->assertSessionHasNoErrors();
    }
}
