<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteAccountTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

    public function testDeleteAccount(): void
    {
        $user = $this->userFactory
            ->createOne();

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
