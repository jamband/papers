<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Http\Controllers\User\ManageUsers;
use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see ManageUsers */
class ManageUsersTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->get(route('user.admin'))
            ->assertRedirect(route('admin.login'));

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('user.admin'))
            ->assertRedirect(route('admin.login'));
    }

    public function testView(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->actingAs($adminUser, 'admin')
            ->get(route('user.admin'))
            ->assertOk();
    }
}
