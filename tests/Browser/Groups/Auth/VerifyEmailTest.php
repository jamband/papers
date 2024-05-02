<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\UserFactory;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Routing\UrlGenerator;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VerifyEmailTest extends DuskTestCase
{
    private UserFactory $userFactory;
    private RateLimiter $rateLimiter;
    private UrlGenerator $url;
    private Carbon $carbon;


    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->rateLimiter = $this->app->make(RateLimiter::class);
        $this->url = $this->app->make(UrlGenerator::class);
        $this->carbon = new Carbon();
    }

    use DatabaseMigrations;

    public function testVerifyEmailWhenUsedInvalidHash(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $this->rateLimiter->clear(sha1((string)$user->id));

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = $this->url->temporarySignedRoute(
                'verification.verify',
                $this->carbon->addMinute(),
                ['id' => $user->id, 'hash' => 'invalid_hash']
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertSee(__('Forbidden'))
                ->assertSee('This action is unauthorized.')
            ;
        });
    }

    public function testVerifyEmailWhenExpires(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $this->rateLimiter->clear(sha1((string)$user->id));

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = $this->url->temporarySignedRoute(
                'verification.verify',
                $this->carbon->subMinute(), // expires
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertSee(__('verification.verify.title'))
                ->assertSee(__('verification.verify.message'))
            ;
        });
    }

    public function testVerifyEmail(): void
    {
        $user = $this->userFactory
            ->unverified()
            ->createOne();

        $this->rateLimiter->clear(sha1((string)$user->id));

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = $this->url->temporarySignedRoute(
                'verification.verify',
                $this->carbon->addMinute(),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertRouteIs('home')
                ->assertSee(__('verification.verified'))
            ;
        });
    }
}
