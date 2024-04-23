<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('auth.login'))
            ->assertRedirect(route('home'));

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('auth.login'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('auth.login'))
            ->assertOk();
    }

    public function testLoginFails(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $data['email'] = $user->email;
        $data['password'] = 'wrong_password';

        $this->post(route('auth.login'), $data);

        $this->assertGuest();
    }

    public function testLogin(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $data['email'] = $user->email;
        $data['password'] = 'password';

        $this->post(route('auth.login'), $data)
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }
}
