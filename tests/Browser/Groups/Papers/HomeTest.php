<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testHome(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.home')
                ->assertRouteIs('auth.login')
            ;
        });

        /** @var Paper $paper */
        $paper = PaperFactory::new()
            ->createOne();

        /** @var User $user */
        $user = User::query()
            ->find($paper->user_id);

        $this->browse(function (Browser $browser) use ($user, $paper) {
            $browser->loginAs($user)
                ->visitRoute('paper.home')
                ->assertSeeIn('h1', 'Paper')

                ->clickLink('Create new paper')
                ->assertRouteIs('paper.create')
                ->back()

                ->assertSeeIn('h2', $paper->title)
                ->assertSee($paper->body)

                ->clickLink('Detail')
                ->assertRouteIs('paper.view', [$paper])
                ->back()

                ->clickLink('Update')
                ->assertRouteIs('paper.update', [$paper])
                ->back()

                ->press('@delete-paper-button')
                ->assertDialogOpened('Are you sure?')
                ->dismissDialog()
                ->assertSeeIn('h2', $paper->title)

                ->press('@delete-paper-button')
                ->acceptDialog()
                ->assertDontSee($paper->title)
            ;
        });
    }
}
