<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Site;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

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

    public function testHomeWithAuth(): void
    {
        $user = $this->userFactory
            ->createOne();

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

    public function testLogout(): void
    {
        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('home')
                ->assertSeeLink('Profile')
                ->assertDontSeeLink('Login')
                ->assertDontSeeLink('Register')

                ->press('@logout-button')
                ->waitForRoute('home')
                ->assertRouteIs('home')
                ->assertSeeLink('Login')
                ->assertSeeLink('Register')
                ->assertDontSeeLink('Profile')
            ;
        });
    }
}
