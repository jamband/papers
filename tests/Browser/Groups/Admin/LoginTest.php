<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUser;
use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogin(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->visitRoute('admin.login')
                ->assertSeeIn('h1', 'Login as administrator')

                ->press('Login')
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', 'foo@example.com')
                ->type('password', 'wrong_password')
                ->press('Login')
                ->assertSee(__('auth.failed'))

                ->type('email', $adminUser->email)
                ->type('password', str_repeat($adminUser->name, 2))
                ->press('Login')
                ->assertRouteIs('admin.home')
                ->assertSee('Logged in successfully.')
            ;
        });
    }
}
