<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;
    private PasswordBroker $password;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->password = $this->app->make(PasswordBroker::class);
    }

    public function testResetPasswordInvalidToken(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('password.reset', [
                'token' => 'wrong_token',
                'email' => $user->email,
            ])
                ->assertSeeIn('h1', 'Reset password')
                ->assertInputValue('email', $user->email)

                ->clear('email')
                ->press('Reset Password')
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('password', 'new_password')
                ->type('password_confirmation', 'wrong_new_password')
                ->press('Reset Password')
                ->assertSee(__('validation.confirmed', ['attribute' => 'password']))

                ->type('email', $user->email)
                ->type('password', 'new_password')
                ->type('password_confirmation', 'new_password')
                ->press('Reset Password')
                ->assertSee(__('passwords.token'))
            ;
        });
    }

    public function testResetPassword(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('password.reset', [
                'token' => $this->password->createToken($user),
                'email' => $user->email,
            ])
                ->type('password', 'new_password')
                ->type('password_confirmation', 'new_password')
                ->press('Reset Password')
                ->assertRouteIs('auth.login')
                ->assertSee(__('passwords.reset'))

                ->type('email', $user->email)
                ->type('password', 'new_password')
                ->press('Login')
                ->assertRouteIs('home')
            ;
        });
    }
}
