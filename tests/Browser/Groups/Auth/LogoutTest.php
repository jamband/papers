<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogout(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('home')
                ->assertSeeIn('h1', 'Home')

                ->press('Logout')
                ->assertRouteIs('home')
                ->assertSee('Logged out.')
                ->assertSeeLink('Login')
            ;
        });
    }
}
