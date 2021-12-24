<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\DeleteAccount;
use App\Models\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see DeleteAccount */
class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
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
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('auth.delete'))
            ->assertRedirect(route('password.confirm'));
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withoutMiddleware([RequirePassword::class])
            ->get(route('auth.delete'))
            ->assertOk();
    }

    public function testDeleteAccount(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->assertDatabaseCount(User::class, 1);

        $this->actingAs($user)
            ->withoutMiddleware([RequirePassword::class])
            ->post(route('auth.delete'))
            ->assertRedirect(route('home'));

        $this->assertGuest()
            ->assertDatabaseCount(User::class, 0);
    }
}
