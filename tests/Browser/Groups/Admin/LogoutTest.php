<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    private AdminUserFactory $adminUserFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
    }

    public function testLogout(): void
    {
        $adminUser = $this->adminUserFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.home')

                ->press('Logout')
                ->waitForRoute('home')
                ->assertRouteIs('home')
                ->assertSee('Logged out successfully.')
                ->assertSeeLink('Login')
            ;
        });
    }
}
