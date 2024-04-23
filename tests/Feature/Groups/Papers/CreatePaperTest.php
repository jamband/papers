<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatePaperTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
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
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('paper.create'))
            ->assertOk();
    }

    public function testCreatePaper(): void
    {
        $this->assertDatabaseCount(Paper::class, 0);

        $data['title'] = 'title1';
        $data['body'] = 'body1';

        $this->actingAs(UserFactory::new()->createOne())
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
