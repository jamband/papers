<?php

declare(strict_types=1);

namespace Tests\Feature\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('paper.view', ['id' => 1]))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('paper.home'))
            ->assertRedirect(route('auth.login'));
    }

    public function testPaperNotFound(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.view', ['id' => 1]))
            ->assertNotFound();
    }

    public function testViewFails(): void
    {
        /** @var User[] $users */
        $users = User::factory()->count(2)->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create([
            'user_id' => $users[0]->id,
        ]);

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->get(route('paper.view', [$paper]))
            ->assertNotFound();
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.view', [$paper]))
            ->assertOk();
    }
}
