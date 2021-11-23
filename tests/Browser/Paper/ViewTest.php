<?php

declare(strict_types=1);

namespace Tests\Browser\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ViewTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testView(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.view', ['id' => 1])
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
