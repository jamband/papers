<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ForgotPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testForgotPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('password.forgot')
                ->assertSeeIn('h1', 'Forgot password')

                ->press('Send Email')
                ->assertSee(__('validation.required', ['attribute' => 'email']))

                ->type('email', $this->faker->email)
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
