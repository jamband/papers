<?php

declare(strict_types=1);

namespace Tests\Browser\Site;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testHome(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('home')
                ->assertSeeIn('h1', 'Home')
                ->assertSeeLink('Papers')
                ->assertSeeLink('Login')
                ->assertSeeLink('Register')
                ->assertSeeLink('About')
                ->assertSeeLink('Contact')
                ->assertSeeLink('GitHub')
                ->assertDontSeeLink('Profile')
            ;
        });
    }

    /**
     * @throws Throwable
     */
    public function testHomeWithAuth(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('home')
                ->assertSeeIn('h1', 'Home')
                ->assertSeeLink('Papers')
                ->assertSeeLink('Profile')
                ->assertSeeLink('About')
                ->assertSeeLink('Contact')
                ->assertSeeLink('GitHub')
                ->assertDontSeeLink('Login')
                ->assertDontSeeLink('Register')
            ;
        });
    }

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
                ->assertSeeLink('Profile')
                ->assertDontSeeLink('Login')
                ->assertDontSeeLink('Register')

                ->press('@logout-button')
                ->assertRouteIs('home')
                ->assertSeeLink('Login')
                ->assertSeeLink('Register')
                ->assertDontSeeLink('Profile')
            ;
        });
    }
}
