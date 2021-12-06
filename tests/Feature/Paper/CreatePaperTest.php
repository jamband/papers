<?php

declare(strict_types=1);

namespace Tests\Feature\Paper;

use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('paper.create'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('paper.create'))
            ->assertRedirect(route('auth.login'));
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.create'))
            ->assertOk();
    }

    public function testCreatePaper(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertDatabaseCount(Paper::class, 0);

        $data['title'] = 'title1';
        $data['body'] = 'body1';

        $this->actingAs($user)
            ->post(route('paper.create'), $data)
            ->assertRedirect(route('paper.view', ['id' => 1]));

        $this->assertDatabaseCount(Paper::class, 1);

        $this->assertDatabaseHas(Paper::class, [
            'id' => 1,
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
    }
}
