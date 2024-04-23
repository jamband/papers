<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->get(route('admin.users'))
            ->assertRedirect(route('admin.login'));

        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('admin.users'))
            ->assertRedirect(route('admin.login'));
    }

    public function testView(): void
    {
        $this->actingAs(AdminUserFactory::new()->createOne(), 'admin')
            ->get(route('admin.users'))
            ->assertOk();
    }
}
