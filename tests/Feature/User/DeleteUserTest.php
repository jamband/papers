<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\AdminUser;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->post(route('user.delete', ['id' => 1]))
            ->assertRedirect(route('auth.login'));

        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('user.delete', ['id' => 1]))
            ->assertRedirect(route('auth.login'));
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
            ->post(route('user.delete', [$user]))
            ->assertRedirect(route('user.admin'));

        $this->assertDatabaseCount(User::class, 0);
        $this->assertDatabaseCount(Paper::class, 0);
    }
}
