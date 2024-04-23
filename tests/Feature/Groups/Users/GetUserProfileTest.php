<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Users;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetUserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifiedMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
            ->get(route('profile'))
            ->assertRedirect(route('verification.notice'));
    }

    public function testAuthMiddleware(): void
    {
        $this->get(route('profile'))
            ->assertRedirect(route('auth.login'));
    }

    public function testGetUserProfile(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('profile'))
            ->assertOk();
    }
}
