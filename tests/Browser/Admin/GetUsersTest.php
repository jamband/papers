<?php

declare(strict_types=1);

namespace Tests\Browser\Admin;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class GetUsersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testManageUsers(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.users')
                ->assertRouteIs('admin.login')
            ;
        });

        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'foo',
            'email' => 'foo@example.com',
        ]);

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
