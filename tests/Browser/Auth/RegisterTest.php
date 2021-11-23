<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testRegister(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.register')
                ->assertSeeIn('h1', 'Register')
                ->clickLink('Login from this link')
                ->assertRouteIs('auth.login')
                ->back()

                ->press('Register')
                ->assertSee(__('validation.required', ['attribute' => 'name']))
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', $user->email)
                ->press('Register')
                ->assertSee(__('validation.unique', ['attribute' => 'email']))

                ->type('password', 'new_user_password')
                ->type('password_confirmation', 'wrong_password')
                ->press('Register')
                ->assertSee(__('validation.confirmed', ['attribute' => 'password']))

                ->type('name', 'new_user')
                ->type('email', 'new_user@example.com')
                ->type('password', 'new_user_password')
                ->type('password_confirmation', 'new_user_password')
                ->press('Register')
                ->assertRouteIs('verification.notice')
            ;
        });
    }
}
