<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    private AdminUserFactory $adminUserFactory;
    private UserFactory $userFactory;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testAuthAdminMiddleware(): void
    {
        $this->get($this->url->route('admin.users'))
            ->assertRedirect($this->url->route('admin.login'));

        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('admin.users'))
            ->assertRedirect($this->url->route('admin.login'));
    }

    public function testView(): void
    {
        $this->actingAs($this->adminUserFactory->makeOne(), 'admin')
            ->get($this->url->route('admin.users'))
            ->assertOk();
    }
}
