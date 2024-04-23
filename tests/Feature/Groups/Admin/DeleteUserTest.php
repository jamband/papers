<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthAdminMiddleware(): void
    {
        $this->post(route('admin.user.delete', ['id' => 1]))
            ->assertRedirect(route('admin.login'));

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('admin.user.delete', ['id' => 1]))
            ->assertRedirect(route('admin.login'));
    }

    public function testDeleteUser(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        PaperFactory::new()
            ->createOne(['user_id' => $user->id]);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Paper::class, 1);

        $this->actingAs(AdminUserFactory::new()->createOne(), 'admin')
            ->post(route('admin.user.delete', [$user]))
            ->assertRedirect(route('admin.users'));

        $this->assertDatabaseCount(User::class, 0);
        $this->assertDatabaseCount(Paper::class, 0);
    }
}
