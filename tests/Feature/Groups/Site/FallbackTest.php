<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Site;

use Illuminate\Support\Str;
use Tests\TestCase;

class FallbackTest extends TestCase
{
    public function testFallback(): void
    {
        $this->get('/'.Str::random())
            ->assertNotFound();
    }
}
