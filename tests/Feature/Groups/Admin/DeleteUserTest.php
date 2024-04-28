<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    private AdminUserFactory $adminUserFactory;
    private UserFactory $userFactory;
    private PaperFactory $paperFactory;
    private User $user;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
        $this->userFactory = new UserFactory();
        $this->paperFactory = new PaperFactory();
        $this->user = new User();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testAuthAdminMiddleware(): void
    {
        $this->post($this->url->route('admin.user.delete', ['id' => 1]))
            ->assertRedirect($this->url->route('admin.login'));

        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('admin.user.delete', ['id' => 1]))
            ->assertRedirect($this->url->route('admin.login'));
    }

    public function testDeleteUser(): void
    {
        $paper = $this->paperFactory
            ->createOne();

        $user = $this->user->find($paper->user_id);

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Paper::class, 1);

        $this->actingAs($this->adminUserFactory->makeOne(), 'admin')
            ->post($this->url->route('admin.user.delete', [$user]))
            ->assertRedirect($this->url->route('admin.users'));

        $this->assertDatabaseCount(User::class, 0);
        $this->assertDatabaseCount(Paper::class, 0);
    }
}
