<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaperScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testInvalidByUserId(): void
    {
        User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->assertFalse((new Paper)->byUserId($paper->user_id + 1)->exists());
    }

    public function testByUserId(): void
    {
        /** @var User[] $users */
        $users = User::factory()->count(5)->create();

        /** @var Paper $paper */
        $papers = Paper::factory()->count(2)->create([
            'user_id' => $users[0]->id,
        ]);

        $this->assertCount(2, (new Paper)->byUserId($papers[0]->user_id)->get());
    }
}
