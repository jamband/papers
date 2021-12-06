<?php

declare(strict_types=1);

namespace Tests\Feature\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatePaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('paper.update', ['id' => 1]))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('paper.update', ['id' => 1]))
            ->assertRedirect(route('auth.login'));
    }

    public function testPaperNotFound(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.update', ['id' => 1]))
            ->assertNotFound();
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.update', [$paper]))
            ->assertOk();
    }

    public function testUpdatePaperFails(): void
    {
        /** @var User[] $users */
        $users = User::factory()->count(2)->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create([
            'user_id' => $users[0]->id,
        ]);

        $data['title'] = 'updated_title1';
        $data['body'] = 'updated_body1';

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->post(route('paper.update', [$paper]), $data)
            ->assertNotFound();
    }

    public function testUpdatePaper(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Paper $paper */
        $paper = Paper::factory()->create();

        $this->assertDatabaseCount(Paper::class, 1);

        $data['title'] = 'updated_title1';
        $data['body'] = 'updated_body1';

        $this->actingAs($user)
            ->post(route('paper.update', [$paper]), $data);

        $this->assertDatabaseCount(Paper::class, 1);

        $this->assertDatabaseHas(Paper::class, [
            'id' => 1,
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
    }
}
