<?php

declare(strict_types=1);

namespace Tests\Browser\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testHome(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.home')
                ->assertRouteIs('auth.login')
            ;
        });

        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create([
            'user_id' => $user->id,
            'title' => 'title1',
            'body' => 'body1',
        ]);

        $this->browse(function (Browser $browser) use ($user, $paper) {
            $browser->loginAs($user)
                ->visitRoute('paper.home')
                ->assertSeeIn('h1', 'Paper')

                ->clickLink('Create new paper')
                ->assertRouteIs('paper.create')
                ->back()

                ->assertSeeIn('h2', 'title1')
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
