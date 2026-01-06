<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateTest extends DuskTestCase
{
    use DatabaseMigrations;

    private PaperFactory $paperFactory;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paperFactory = new PaperFactory();
        $this->user = new User();
    }

    public function testUpdate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.update', ['id' => 1])
                ->assertRouteIs('auth.login')
            ;
        });

        $paper = $this->paperFactory
            ->createOne();

        $user = $this->user::query()
            ->find($paper->user_id);

        $this->browse(function (Browser $browser) use ($user, $paper) {
            $browser->loginAs($user)
                ->visitRoute('paper.update', ['id' => $paper->id])
                ->assertSeeIn('h1', 'Update paper')
                ->assertInputValue('title', $paper->title)
                ->assertInputValue('body', $paper->body)

                ->clear('title')
                ->clear('body')
                ->press('@update-paper-button')
                ->waitForRoute('paper.update', ['id' => $paper->id])
                ->assertSee(__('validation.required', ['attribute' => 'title']))
                ->assertSee(__('validation.required', ['attribute' => 'body']))

                ->type('title', 'updated_title1')
                ->type('body', 'updated_body1')
                ->press('@update-paper-button')
                ->waitForRoute('paper.view', [$paper])
                ->assertRouteIs('paper.view', [$paper])
                ->assertSeeIn('h1', 'updated_title1')
                ->assertSee('updated_body1')
            ;
        });
    }
}
