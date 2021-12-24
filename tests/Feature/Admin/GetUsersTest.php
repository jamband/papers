<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\GetUsers;
use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see GetUsers */
class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->get(route('admin.users'))
            ->assertRedirect(route('admin.login'));

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.users'))
            ->assertRedirect(route('admin.login'));
    }

    public function testView(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->actingAs($adminUser, 'admin')
            ->get(route('admin.users'))
            ->assertOk();
    }
}
