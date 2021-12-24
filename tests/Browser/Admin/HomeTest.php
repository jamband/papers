<?php

declare(strict_types=1);

namespace Tests\Browser\Admin;

use App\Models\AdminUser;
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
            $browser->visitRoute('admin.home')
                ->assertRouteIs('admin.login');
        });

        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.home')
                ->assertSeeIn('h1', 'Admin Home')

                ->clickLink('Users')
                ->assertRouteIs('admin.users')
                ->back()

                ->press('Logout')
                ->assertRouteIs('home')
                ->assertSeeLink('Login')
            ;
        });
    }
}
