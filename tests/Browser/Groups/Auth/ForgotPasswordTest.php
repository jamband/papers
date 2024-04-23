<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ForgotPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testForgotPassword(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('password.forgot')
                ->assertSeeIn('h1', 'Forgot password')

                ->press('Send Email')
                ->assertSee(__('validation.required', ['attribute' => 'email']))

                ->type('email', 'foo@example.com')
                ->press('Send Email')
                ->assertSee(__('passwords.user'))

                ->type('email', $user->email)
                ->press('Send Email')
                ->assertRouteIs('password.forgot')
                ->assertSee(__('passwords.sent'))

                ->type('email', $user->email)
                ->press('Send Email')
                ->assertSee(__('passwords.throttled'))
            ;
        });
    }
}
