<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class EmailVerificationPromptTest extends TestCase
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
        $this->get($this->url->route('verification.notice'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testHasVerifiedEmail(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('verification.notice'))
            ->assertRedirect($this->url->route('home'));
    }

    public function testHaveNotVerifiedEmail(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->get($this->url->route('verification.notice'))
            ->assertOk();
    }
}
