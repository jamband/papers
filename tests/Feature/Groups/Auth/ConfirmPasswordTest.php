<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class ConfirmPasswordTest extends TestCase
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
        $this->get($this->url->route('password.confirm'))
            ->assertRedirect($this->url->route('auth.login'));

        $this->post($this->url->route('password.confirm'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testThrottleMiddleware(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('password.confirm'))
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testView(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('password.confirm'))
            ->assertOk();
    }

    public function testConfirmPasswordFails(): void
    {
        $this->actingAs($this->userFactory->createOne())
            ->post($this->url->route('password.confirm'), [
                'password' => 'wrong_password',
            ])
            ->assertSessionHasErrors();
    }

    public function testConfirmPassword(): void
    {
        $this->actingAs($this->userFactory->createOne())
            ->post($this->url->route('password.confirm'), [
                'password' => $this->userFactory::PASSWORD,
            ])
            ->assertSessionHasNoErrors();
    }
}
