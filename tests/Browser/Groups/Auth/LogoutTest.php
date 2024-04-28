<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

    public function testLogout(): void
    {
        $user = $this->userFactory
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
