<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUser;
use App\Groups\Admin\AdminUserFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GetUsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testManageUsers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.users')
                ->assertRouteIs('admin.login')
            ;
        });

        /** @var AdminUser $adminUser */
        $adminUser = AdminUserFactory::new()
            ->createOne();

        /** @var User $user */
        $user = UserFactory::new()
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
