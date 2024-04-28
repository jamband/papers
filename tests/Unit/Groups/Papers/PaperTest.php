<?php

declare(strict_types=1);

namespace Tests\Unit\Groups\Papers;

use App\Groups\Papers\PaperFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaperTest extends TestCase
{
    use RefreshDatabase;

    private PaperFactory $paperFactory;
    private Carbon $carbon;

    private const CREATED_AT_FORMAT = 'F jS Y, g:i a';
    private const UPDATED_AT_FORMAT = self::CREATED_AT_FORMAT;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paperFactory = new PaperFactory();
        $this->carbon = new Carbon();
    }

    public function testCreatedAtAttributeValue(): void
    {
        $paper = $this->paperFactory
            ->makeOne();

        $this->assertSame(
            $this->carbon::parse($paper->created_at)->format(self::CREATED_AT_FORMAT),
            $paper->created_at
        );
    }

    public function testUpdatedAtAttributeValue(): void
    {
        $paper = $this->paperFactory
            ->makeOne();

        $this->assertSame(
            $this->carbon::parse($paper->updated_at)->format(self::UPDATED_AT_FORMAT),
            $paper->updated_at
        );
    }
}
