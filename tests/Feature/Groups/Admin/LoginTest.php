<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function testGuestMiddleware(): void
    {
        $this->actingAs($this->adminUserFactory->makeOne(), 'admin')
            ->get($this->url->route('admin.login'))
            ->assertRedirect($this->url->route('home'));
    }

    public function testView(): void
    {
        $this->get($this->url->route('admin.login'))
            ->assertOk();
    }

    public function testLoginFails(): void
    {
        $adminUser = $this->adminUserFactory
            ->createOne();

        $this->post($this->url->route('admin.login'), [
            'email' => $adminUser->email,
            'password' => 'wrong_password',
        ]);

        $this->assertGuest('admin');
    }

    public function testLogin(): void
    {
        $adminUser = $this->adminUserFactory
            ->createOne();

        $this->post($this->url->route('admin.login'), [
            'email' => $adminUser->email,
            'password' => $this->adminUserFactory::PASSWORD,
        ])
            ->assertRedirect($this->url->route('admin.home'));

        $this->assertAuthenticated('admin');
    }
}
