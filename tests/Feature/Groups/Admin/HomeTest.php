<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(AdminUserFactory::new()->unverified()->createOne(), 'admin')
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
        $this->actingAs(AdminUserFactory::new()->createOne(), 'admin')
            ->get(route('admin.home'))
            ->assertOk();
    }
}
