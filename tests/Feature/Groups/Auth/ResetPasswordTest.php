<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
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
            ->get($this->url->route('password.reset', ['token' => 'foo']))
            ->assertRedirect($this->url->route('home'));
    }

    public function testView(): void
    {
        $this->get('/reset-password/xxx?foo@example.com')
            ->assertOk();
    }

    public function testResetPasswordFails(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->post($this->url->route('password.update'), [
            'token' => Str::random(60),
            'email' => $user->email,
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
        ])
            ->assertSessionHasErrors();
    }

    public function testResetPassword(): void
    {
        Notification::fake();

        $user = $this->userFactory
            ->createOne();

        $this->post($this->url->route('password.forgot'), [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->post($this->url->route('password.update'), [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
            ])
                ->assertSessionHasNoErrors();

            return true;
        });
    }
}
