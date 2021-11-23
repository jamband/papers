<?php

declare(strict_types=1);

namespace Tests\Feature\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeletePaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->post(route('paper.delete', ['id' => 1]))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->post(route('paper.delete', ['id' => 1]))
            ->assertRedirect(route('auth.login'));
    }

    public function testPaperNotFound(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('paper.delete', ['id' => 1]))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testDeletePaperFails(): void
    {
        /** @var User[] $users */
        $users = User::factory()->count(2)->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create([
            'user_id' => $users[0]->id,
        ]);

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->post(route('paper.delete', [$paper]))
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testDeletePaper(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->assertDatabaseCount(Paper::class, 1);

        $this->actingAs($user)
            ->post(route('paper.delete', [$paper]))
            ->assertRedirect(route('paper.home'));

        $this->assertDatabaseCount(Paper::class, 0);
    }
}
