<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class DeletePaperTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private PaperFactory $paperFactory;
    private User $user;
    private Paper $paper;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->paperFactory = new PaperFactory();
        $this->user = new User();
        $this->paper = new Paper();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->post($this->url->route('paper.delete', ['id' => 1]))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->post($this->url->route('paper.delete', ['id' => 1]))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testPaperNotFound(): void
    {
        $this->actingAs($this->userFactory->createOne())
            ->post($this->url->route('paper.delete', ['id' => 1]))
            ->assertNotFound();
    }

    public function testDeletePaperFails(): void
    {
        /** @var array<int, User> $users */
        $users = $this->userFactory
            ->count(2)
            ->create();

        $paper = $this->paperFactory
            ->create(['user_id' => $users[0]->id]);

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->post($this->url->route('paper.delete', [$paper]))
            ->assertNotFound();
    }

    public function testDeletePaper(): void
    {
        /** @var Paper $paper */
        $paper = $this->paperFactory
            ->createOne();

        $this->assertDatabaseCount($this->paper::class, 1);

        /** @var User $user */
        $user = $this->user::query()
            ->find($paper->user_id);

        $this->actingAs($user)
            ->post($this->url->route('paper.delete', [$paper]))
            ->assertRedirect($this->url->route('paper.home'));

        $this->assertDatabaseCount($this->paper::class, 0);
    }
}
