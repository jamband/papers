<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Admin;

use App\Groups\Admin\AdminUserFactory;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    private AdminUserFactory $adminUserFactory;
    private PaperFactory $paperFactory;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUserFactory = new AdminUserFactory();
        $this->paperFactory = new PaperFactory();
        $this->user = new User();
    }

    public function testDeleteUser(): void
    {
        $adminUser = $this->adminUserFactory
            ->createOne();

        $paper = $this->paperFactory
            ->createOne();

        /** @var User $user */
        $user = $this->user::query()
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
