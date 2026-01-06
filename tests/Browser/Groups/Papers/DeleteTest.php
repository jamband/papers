<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteTest extends DuskTestCase
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

    public function testDelete(): void
    {
        $paper = $this->paperFactory
            ->createOne();

        $user = $this->user::query()
            ->find($paper->user_id);

        $this->browse(function (Browser $browser) use ($user, $paper) {
            $browser->loginAs($user)
                ->visitRoute('paper.home')
                ->assertSee($paper->title)

                ->press('@delete-paper-button')
                ->acceptDialog()
                ->waitForRoute('paper.home')
                ->assertRouteIs('paper.home')
                ->assertDontSee($paper->title)
            ;
        });
    }
}
