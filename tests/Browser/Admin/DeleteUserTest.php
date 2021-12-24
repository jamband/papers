<?php

declare(strict_types=1);

namespace Tests\Browser\Admin;

use App\Models\AdminUser;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class DeleteUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testDeleteUser(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'foo',
            'email' => 'foo@example.com',
        ]);

        Paper::factory()->create([
            'user_id' => $user->id,
        ]);

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
