<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Paper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see Paper */
class PaperTest extends TestCase
{
    use RefreshDatabase;

    private const CREATED_AT_FORMAT = 'F jS Y, g:i a';
    private const UPDATED_AT_FORMAT = self::CREATED_AT_FORMAT;

    public function testCreatedAtAttributeValue(): void
    {
        User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->assertTrue(is_string($paper->created_at));

        $this->assertSame(
            Carbon::parse($paper->created_at)->format(self::CREATED_AT_FORMAT),
            $paper->created_at
        );
    }

    public function testUpdatedAtAttributeValue(): void
    {
        User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->assertTrue(is_string($paper->updated_at));

        $this->assertSame(
            Carbon::parse($paper->updated_at)->format(self::UPDATED_AT_FORMAT),
            $paper->updated_at
        );
    }
}
