<?php

declare(strict_types=1);

namespace Tests\Browser\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * @throws Throwable
     */
    public function testLogin(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser->visitRoute('admin.login')
                ->assertSeeIn('h1', 'Login as administrator')

                ->press('Login')
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']))

                ->type('email', $this->faker->email)
                ->type('password', $this->faker->word)
                ->press('Login')
                ->assertSee(__('auth.failed'))

                ->type('email', $adminUser->email)
                ->type('password', str_repeat($adminUser->name, 2))
                ->press('Login')
                ->assertRouteIs('admin.home')
                ->assertSee('Logged in successfully.')
            ;
        });
    }
}
