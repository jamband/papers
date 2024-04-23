<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUser;
use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLogout(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUserFactory::new()
            ->createOne();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.home')

                ->press('Logout')
                ->assertRouteIs('home')
                ->assertSee('Logged out successfully.')
                ->assertSeeLink('Login')
            ;
        });
    }
}
