<?php

declare(strict_types=1);

namespace Tests\Browser\Site;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ProfileTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testProfile(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('profile')
                ->assertRouteIs('auth.login')
            ;
        });

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Foo',
            'email' => 'foo@example.com',
        ]);

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
