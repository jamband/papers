<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUser;
use App\Groups\Admin\AdminUserFactory;
use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testDeleteUser(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUserFactory::new()
            ->createOne();

        /** @var Paper $paper */
        $paper = PaperFactory::new()
            ->createOne();

        /** @var User $user */
        $user = User::query()
            ->find($paper->user_id);

        $this->browse(function (Browser $browser) use ($adminUser, $user) {
            $browser->loginAs($adminUser, 'admin')
                ->visitRoute('admin.users')
                ->press('@delete-user-button')
                ->acceptDialog()
                ->assertRouteIs('admin.users')
                ->assertSee($user->name.' has been deleted.')
                ->assertDontSee('Name: '.$user->name)
                ->assertDontSee('Email: '.$user->email)
            ;
        });
    }
}
