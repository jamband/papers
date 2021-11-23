<?php

declare(strict_types=1);

namespace Tests\Feature\Paper;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetPapersTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('paper.home'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('paper.home'))
            ->assertRedirect(route('auth.login'));
    }

    public function testView(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('paper.home'))
            ->assertStatus(Response::HTTP_OK);
    }
}
