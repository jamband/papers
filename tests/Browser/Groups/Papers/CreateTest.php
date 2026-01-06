<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    use DatabaseMigrations;

    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

    public function testCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.create')
                ->assertRouteIs('auth.login')
            ;
        });

        $user = $this->userFactory
            ->createOne();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visitRoute('paper.create')
                ->assertSeeIn('h1', 'Create new paper')

                ->press('@create-paper-button')
                ->waitForRoute('paper.create')
                ->assertSee(__('validation.required', ['attribute' => 'title']))
                ->assertSee(__('validation.required', ['attribute' => 'body']))

                ->type('title', 'title1')
                ->type('body', 'body1')
                ->press('@create-paper-button')
                ->waitForRoute('paper.view', ['id' => 1])
                ->assertRouteIs('paper.view', ['id' => 1])
                ->assertSee('title1')
                ->assertSee('body1')
                ->back()

                ->clickLink('Back to Papers')
                ->assertRouteIs('paper.home')
            ;
        });
    }
}
