<?php

declare(strict_types=1);

namespace Tests\Browser\Site;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class AboutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testAbout(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('about')
                ->assertSeeIn('h1', 'About');
        });
    }
}
