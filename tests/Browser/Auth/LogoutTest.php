<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testLogout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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
