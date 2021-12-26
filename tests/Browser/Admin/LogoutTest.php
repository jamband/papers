<?php

declare(strict_types=1);

namespace Tests\Browser\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testLogout(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

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
