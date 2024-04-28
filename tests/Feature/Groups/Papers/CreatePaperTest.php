<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Papers\Paper;
use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class CreatePaperTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private UrlGenerator $url;
    private Paper $paper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
        $this->paper = new Paper();
    }

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs($this->userFactory->unverified()->makeOne())
            ->get($this->url->route('paper.create'))
            ->assertRedirect($this->url->route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('paper.create'))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testView(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('paper.create'))
            ->assertOk();
    }

    public function testCreatePaper(): void
    {
        $this->assertDatabaseCount($this->paper::class, 0);

        $this->actingAs($this->userFactory->createOne())
            ->post($this->url->route('paper.create'), [
                'title' => 'title1',
                'body' => 'body1',
            ])
            ->assertRedirect($this->url->route('paper.view', ['id' => 1]));

        $this->assertDatabaseCount($this->paper::class, 1);

        $this->assertDatabaseHas($this->paper::class, [
            'id' => 1,
            'title' => 'title1',
            'body' => 'body1',
        ]);
    }
}
