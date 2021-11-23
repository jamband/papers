<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($adminUser, 'admin')
            ->post(route('admin.logout'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));
    }

    public function testLogout(): void
    {
        /** @var AdminUser $user */
        $user = AdminUser::factory()->create();

        $this->actingAs($user)
            ->post(route('auth.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
