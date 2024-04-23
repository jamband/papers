<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testDelete(): void
    {
        /** @var Paper $paper */
        $paper = PaperFactory::new()
            ->createOne();

        /** @var User $user */
        $user = User::query()
            ->find($paper->user_id);

        $this->browse(function (Browser $browser) use ($user, $paper) {
            $browser->loginAs($user)
                ->visitRoute('paper.home')
                ->assertSee($paper->title)

                ->press('@delete-paper-button')
                ->acceptDialog()
                ->assertDontSee($paper->title)
            ;
        });
    }
}
