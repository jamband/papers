<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    private AdminUserFactory $adminUserFactory;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs($this->adminUserFactory->unverified()->makeOne(), 'admin')
            ->get($this->url->route('admin.home'))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('admin.home'))
            ->assertRedirect($this->url->route('admin.login'));
    }

    public function testView(): void
    {
        $this->actingAs($this->adminUserFactory->makeOne(), 'admin')
            ->get($this->url->route('admin.home'))
            ->assertOk();
    }
}
