<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($adminUser, 'admin')
            ->get(route('admin.home'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('admin.home'))
            ->assertRedirect(route('admin.login'));
    }

    public function testView(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->actingAs($adminUser, 'admin')
            ->get(route('admin.home'))
            ->assertOk();
    }
}
