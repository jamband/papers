<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogin(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.login')
                ->assertSeeIn('h1', 'Login')

                ->clickLink('Forgot password?')
                ->assertRouteIs('password.forgot')
                ->back()

                ->press('Login')
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', 'foo@exmaple.com')
                ->type('password', 'wrong_password')
                ->press('Login')
                ->assertSee(__('auth.failed'))

                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertRouteIs('home')
                ->assertSee('Logged in.')
            ;
        });
    }
}
