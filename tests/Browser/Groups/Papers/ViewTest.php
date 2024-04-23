<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testView(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.view', ['id' => 1])
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
                ->visitRoute('paper.view', [$paper])
                ->assertSeeIn('h1', $paper->title)
                ->assertSee($paper->body)
                ->assertSee('Created at: '.$paper->created_at)
                ->assertSee('Updated at: '.$paper->updated_at)

                ->clickLink('Update')
                ->assertRouteIs('paper.update', [$paper])
                ->back()

                ->clickLink('Back to Papers')
                ->assertRouteIs('paper.home')
                ->back()

                ->press('Delete')
                ->assertDialogOpened('Are you sure?')
                ->dismissDialog()

                ->press('Delete')
                ->acceptDialog()
                ->assertRouteIs('paper.home')
                ->assertDontSee($paper->title)
            ;
        });
    }
}
