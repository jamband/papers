<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testAuthMiddleware(): void
    {
        $this->post($this->url->route('auth.logout'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testLogout(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('auth.logout'))
            ->assertRedirect($this->url->route('home'));

        $this->assertGuest();
    }
}
