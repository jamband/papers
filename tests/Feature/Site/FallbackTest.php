<?php

declare(strict_types=1);

namespace Tests\Feature\Site;

use App\Http\Controllers\Site\Fallback;
use Illuminate\Support\Str;
use Tests\TestCase;

/** @see Fallback */
class FallbackTest extends TestCase
{
    public function testFallback(): void
    {
        $this->get('/'.Str::random())
            ->assertNotFound();
    }
}
