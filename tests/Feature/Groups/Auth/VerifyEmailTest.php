<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private UrlGenerator $url;
    private Carbon $carbon;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
        $this->carbon = new Carbon();
    }

    public function testAuthMiddleware(): void
    {
        $this->get($this->url->route('verification.verify', ['id' => 1, 'hash' => 1]))
            ->assertRedirect($this->url->route('auth.login'));
    }

    public function testSignedMiddleware(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $verificationUrl = $this->url->temporarySignedRoute(
            'verification.verify',
            $this->carbon->subMinute(), // expires
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertForbidden();

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }

    public function testThrottleMiddleware(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $verificationUrl = $this->url->temporarySignedRoute(
            'verification.verify',
            $this->carbon->addMinutes(),
            ['id' => $user->id, 'hash' => sha1('wrong_email')]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertHeader('X-RATELIMIT-REMAINING', 5);
    }

    public function testVerifyEmail(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $verificationUrl = $this->url->temporarySignedRoute(
            'verification.verify',
            $this->carbon->addMinutes(),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertRedirect($this->url->route('home'));

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
