<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\DeleteUser;
use App\Models\AdminUser;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see DeleteUser */
class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->post(route('admin.user.delete', ['id' => 1]))
            ->assertRedirect(route('admin.login'));

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.user.delete', ['id' => 1]))
            ->assertRedirect(route('admin.login'));
    }

    public function testDeleteUser(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        /** @var User $user */
        $user = User::factory()->create();

        Paper::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Paper::class, 1);

        $this->actingAs($adminUser, 'admin')
            ->post(route('admin.user.delete', [$user]))
            ->assertRedirect(route('admin.users'));

        $this->assertDatabaseCount(User::class, 0);
        $this->assertDatabaseCount(Paper::class, 0);
    }
}
