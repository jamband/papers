<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Password;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testResetPasswordInvalidToken(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
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
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('password.reset', [
                'token' => Password::createToken($user),
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
