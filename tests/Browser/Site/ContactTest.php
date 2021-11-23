<?php

declare(strict_types=1);

namespace Tests\Browser\Site;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ContactTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testContact(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('contact')
                ->assertSeeIn('h1', 'Contact');
        });
    }
}
