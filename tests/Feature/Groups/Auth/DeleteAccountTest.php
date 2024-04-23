<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
            ->get(route('auth.delete'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('auth.delete'))
            ->assertRedirect(route('auth.login'));
    }

    public function testPasswordConfirmMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('auth.delete'))
            ->assertRedirect(route('password.confirm'));
    }

    public function testView(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->withoutMiddleware([RequirePassword::class])
            ->get(route('auth.delete'))
            ->assertOk();
    }

    public function testDeleteAccount(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->assertDatabaseCount(User::class, 1);

        $this->actingAs($user)
            ->withoutMiddleware([RequirePassword::class])
            ->post(route('auth.delete'))
            ->assertRedirect(route('home'));

        $this->assertGuest()
            ->assertDatabaseCount(User::class, 0);
    }
}
