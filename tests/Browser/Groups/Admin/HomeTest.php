<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    private AdminUserFactory $adminUserFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
    }

    public function testHome(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.home')
                ->assertRouteIs('admin.login');
        });

        $adminUser = $this->adminUserFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.home')
                ->assertSeeIn('h1', 'Admin Home')

                ->clickLink('Users')
                ->assertRouteIs('admin.users')
                ->back()
                ->waitForRoute('admin.home')

                ->press('Logout')
                ->waitForRoute('home')
                ->assertRouteIs('home')
                ->assertSeeLink('Login')
            ;
        });
    }
}
