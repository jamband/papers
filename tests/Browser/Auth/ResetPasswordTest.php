<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testResetPasswordInvalidToken(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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

    /**
     * @throws Throwable
     */
    public function testResetPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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
