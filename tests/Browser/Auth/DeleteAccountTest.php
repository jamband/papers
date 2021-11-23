<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class DeleteAccountTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testDeleteAccount(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('profile')
                ->assertSeeIn('h1', 'Profile')

                ->clickLink('Delete account')
                ->assertRouteIs('password.confirm')

                ->press('Confirm')
                ->assertSee(__('auth.password'))

                ->type('password', 'password')
                ->press('Confirm')
                ->assertRouteIs('auth.delete')
                ->assertSeeIn('h1', 'Delete your account')

                ->clickLink('Cancel')
                ->assertRouteIs('home')
                ->assertSeeLink('Profile')
                ->back()

                ->press('Delete account')
                ->assertDialogOpened('Are you sure you want to delete it?')
                ->dismissDialog()

                ->press('Delete account')
                ->acceptDialog()
                ->assertRouteIs('home')
                ->assertSee('Account deletion has been completed.')
                ->assertSeeLink('Login')
                ->assertSeeLink('Register')
            ;
        });
    }
}
