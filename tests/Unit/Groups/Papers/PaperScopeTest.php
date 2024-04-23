<?php

declare(strict_types=1);

namespace Tests\Unit\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaperScopeTest extends TestCase
{
    use RefreshDatabase;

    private Paper $paper;

    protected function setUp(): void
    {
        parent::setup();

        $this->paper = new Paper();
    }

    public function testByUserId(): void
    {
        /** @var array<int, Paper> $papers */
        $papers = Paperfactory::new()
            ->count(3)
            ->create();

        $this->assertSame(1, $this->paper->byUserId($papers[0]->user_id)->count());
        $this->assertSame(1, $this->paper->byUserId($papers[1]->user_id)->count());
        $this->assertSame(1, $this->paper->byUserId($papers[2]->user_id)->count());
        $this->assertSame(0, $this->paper->byUserId(4)->count());
    }
}
