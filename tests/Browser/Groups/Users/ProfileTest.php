<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Users;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testProfile(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('profile')
                ->assertRouteIs('auth.login')
            ;
        });

        /** @var User $user */
        $user = UserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('profile')
                ->assertSeeIn('h1', 'Profile')
                ->assertSee('Name: '.$user->name)
                ->assertSee('Email: '.$user->email)
                ->assertSeeLink('Delete account')

                ->clickLink('Delete account')
                ->assertRouteIs('password.confirm')
            ;
        });
    }
}
