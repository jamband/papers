<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

    public function testRegister(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visitRoute('auth.register')
                ->assertSeeIn('h1', 'Register')
                ->clickLink('Login from this link')
                ->assertRouteIs('auth.login')
                ->back()

                ->press('Register')
                ->waitForRoute('auth.register')
                ->assertSee(__('validation.required', ['attribute' => 'name']))
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', $user->email)
                ->press('Register')
                ->waitForRoute('auth.register')
                ->assertSee(__('validation.unique', ['attribute' => 'email']))

                ->type('password', 'new_user_password')
                ->type('password_confirmation', 'wrong_password')
                ->press('Register')
                ->waitForRoute('auth.register')
                ->assertSee(__('validation.confirmed', ['attribute' => 'password']))

                ->type('name', 'new_user')
                ->type('email', 'new_user@example.com')
                ->type('password', 'new_user_password')
                ->type('password_confirmation', 'new_user_password')
                ->press('Register')
                ->waitForRoute('verification.notice')
                ->assertRouteIs('verification.notice')
            ;
        });
    }
}
