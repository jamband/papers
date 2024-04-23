<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(AdminUserFactory::new()->unverified()->createOne(), 'admin')
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
        $this->actingAs(AdminUserFactory::new()->createOne())
            ->post(route('auth.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
