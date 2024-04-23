<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Site;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AboutTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAbout(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('about')
                ->assertSeeIn('h1', 'About');
        });
    }
}
