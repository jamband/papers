<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class LoginTest extends TestCase
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

    public function testGuestMiddleware(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('auth.login'))
            ->assertRedirect($this->url->route('home'));

        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('auth.login'))
            ->assertRedirect($this->url->route('home'));
    }

    public function testView(): void
    {
        $this->get($this->url->route('auth.login'))
            ->assertOk();
    }

    public function testLoginFails(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->post($this->url->route('auth.login'), [
            'email' => $user->email,
            'password' => 'wrong_password',
        ]);

        $this->assertGuest();
    }

    public function testLogin(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->post($this->url->route('auth.login'), [
            'email' => $user->email,
            'password' => $this->userFactory::PASSWORD,
        ])
            ->assertRedirect($this->url->route('home'));

        $this->assertAuthenticated();
    }
}
