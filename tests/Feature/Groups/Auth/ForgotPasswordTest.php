<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
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
            ->get($this->url->route('password.forgot'))
            ->assertRedirect($this->url->route('home'));
    }

    public function testView(): void
    {
        $this->get($this->url->route('password.forgot'))
            ->assertOk();
    }

    public function testForgotPasswordFails(): void
    {
        Notification::fake();

        $this->post($this->url->route('password.forgot'), [
            'email' => 'foo@example.com',
        ]);

        Notification::assertNothingSent();
    }

    public function testForgotPassword(): void
    {
        Notification::fake();

        $user = UserFactory::new()
            ->createOne();

        $this->post($this->url->route('password.forgot'), [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
