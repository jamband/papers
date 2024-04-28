<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GetUsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    private AdminUserFactory $adminUserFactory;
    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
        $this->userFactory = new UserFactory();
    }

    public function testManageUsers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.users')
                ->assertRouteIs('admin.login')
            ;
        });

        $adminUser = $this->adminUserFactory
            ->createOne();

        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($adminUser, $user) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.users')
                ->assertSeeIn('h1', 'Manage Users')
                ->assertSee('Currently logged in as an administrator')

                ->assertSee('Name: '.$user->name)
                ->assertSee('Email: '.$user->email)

                ->press('@delete-user-button')
                ->assertDialogOpened('Are you sure you want to delete it?')
                ->dismissDialog()
            ;
        });
    }
}
