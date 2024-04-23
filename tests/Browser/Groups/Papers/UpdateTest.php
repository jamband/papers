<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testUpdate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('paper.update', ['id' => 1])
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
