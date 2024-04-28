<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Papers\PaperFactory;
use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class GetPaperTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private User $user;
    private PaperFactory $paperFactory;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->user = new User();
        $this->paperFactory = new PaperFactory();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->get($this->url->route('paper.view', ['id' => 1]))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('paper.home'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testPaperNotFound(): void
    {
        $this->actingAs($this->userFactory->createOne())
            ->get($this->url->route('paper.view', ['id' => 1]))
            ->assertNotFound();
    }

    public function testViewFails(): void
    {
        /** @var array<int, User> $users */
        $users = $this->userFactory
            ->count(2)
            ->create();

        $paper = $this->paperFactory
            ->createOne(['user_id' => $users[0]->id]);

        // It fails because the user who created the paper is different.
        $this->actingAs($users[1])
            ->get($this->url->route('paper.view', [$paper]))
            ->assertNotFound();
    }

    public function testView(): void
    {
        $paper = $this->paperFactory
            ->createOne();

        /** @var User $user */
        $user = $this->user::query()
            ->find($paper->user_id);

        $this->actingAs($user)
            ->get($this->url->route('paper.view', [$paper]))
            ->assertOk();
    }
}
