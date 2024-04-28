<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private User $user;
    private UrlGenerator $url;
    private RequirePassword $requirePassword;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->user = new User();
        $this->url = $this->app->make(UrlGenerator::class);
        $this->requirePassword = $this->app->make(RequirePassword::class);
    }

    public function testVerifyMiddleware(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->get($this->url->route('auth.delete'))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('auth.delete'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testPasswordConfirmMiddleware(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('auth.delete'))
            ->assertRedirect($this->url->route('password.confirm'));
    }

    public function testView(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->withoutMiddleware([$this->requirePassword::class])
            ->get($this->url->route('auth.delete'))
            ->assertOk();
    }

    public function testDeleteAccount(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->assertDatabaseCount($this->user::class, 1);

        $this->actingAs($user)
            ->withoutMiddleware([$this->requirePassword::class])
            ->post($this->url->route('auth.delete'))
            ->assertRedirect($this->url->route('home'));

        $this->assertGuest()
            ->assertDatabaseCount($this->user::class, 0);
    }
}
