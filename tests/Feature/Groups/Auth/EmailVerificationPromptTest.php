<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationPromptTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthMiddleware(): void
    {
        $this->get(route('verification.notice'))
            ->assertRedirect(route('auth.login'));
    }

    public function testHasVerifiedEmail(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('verification.notice'))
            ->assertRedirect(route('home'));
    }

    public function testHaveNotVerifiedEmail(): void
    {
        $this->actingAs(UserFactory::new()->unverified()->createOne())
            ->get(route('verification.notice'))
            ->assertOk();
    }
}
