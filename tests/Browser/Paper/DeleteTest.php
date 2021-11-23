<?php

declare(strict_types=1);

namespace Tests\Browser\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class DeleteTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testDelete(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create([
            'user_id' => $user->id,
            'title' => 'title1',
        ]);

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
