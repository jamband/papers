<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testLogin(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.login')
                ->assertSeeIn('h1', 'Login')

                ->clickLink('Forgot password?')
                ->assertRouteIs('password.forgot')
                ->back()

                ->press('Login')
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', $this->faker->email)
                ->type('password', $this->faker->word)
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
