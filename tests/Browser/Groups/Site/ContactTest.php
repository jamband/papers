<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Site;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testContact(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('contact')
                ->assertSeeIn('h1', 'Contact');
        });
    }
}
