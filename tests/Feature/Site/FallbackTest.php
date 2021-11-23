<?php

declare(strict_types=1);

namespace Tests\Feature\Site;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class FallbackTest extends TestCase
{
    public function testFallback(): void
    {
        $this->get('/'.Str::random())
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
