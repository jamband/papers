<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Papers;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetPapersTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
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
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('paper.home'))
            ->assertOk();
    }
}
