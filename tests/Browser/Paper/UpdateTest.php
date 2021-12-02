<?php

declare(strict_types=1);

namespace Tests\Browser\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class UpdateTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testUpdate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.update', ['id' => 1])
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
                ->visitRoute('paper.update', ['id' => $paper->id])
                ->assertSeeIn('h1', 'Update paper')
                ->assertInputValue('title', $paper->title)
                ->assertInputValue('body', $paper->body)

                ->clear('title')
                ->clear('body')
                ->press('@update-paper-button')
                ->assertSee(__('validation.required', ['attribute' => 'title']))
                ->assertSee(__('validation.required', ['attribute' => 'body']))

                ->type('title', 'updated_title1')
                ->type('body', 'updated_body1')
                ->press('@update-paper-button')
                ->assertRouteIs('paper.view', [$paper])
                ->assertSeeIn('h1', 'updated_title1')
                ->assertSee('updated_body1')
            ;
        });
    }
}
