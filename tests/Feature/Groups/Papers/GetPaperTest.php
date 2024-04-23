<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
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
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('paper.view', ['id' => 1]))
            ->assertNotFound();
    }

    public function testViewFails(): void
    {
        /** @var array<int, User> $users */
        $users = UserFactory::new()
            ->count(2)
            ->create();

        /** @var Paper $paper */
        $paper = PaperFactory::new()
            ->createOne(['user_id' => $users[0]->id]);

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->get(route('paper.view', [$paper]))
            ->assertNotFound();
    }

    public function testView(): void
    {
        /** @var Paper $paper */
        $paper = PaperFactory::new()
            ->createOne();

        /** @var User $user */
        $user = User::query()
            ->find($paper->user_id);

        $this->actingAs($user)
            ->get(route('paper.view', [$paper]))
            ->assertOk();
    }
}
