<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Users;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class GetUserProfileTest extends TestCase
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

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->get($this->url->route('profile'))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('profile'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testGetUserProfile(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('profile'))
            ->assertOk();
    }
}
