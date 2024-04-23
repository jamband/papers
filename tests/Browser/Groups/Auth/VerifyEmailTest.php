<?php

declare(strict_types=1);

namespace Tests\Browser\Groups\Auth;

use App\Groups\Users\User;
use App\Groups\Users\UserFactory;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VerifyEmailTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testVerifyEmailWhenUsedInvalidHash(): void
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->unverified()
            ->createOne();

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon())->addMinute(),
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
        /** @var User $user */
        $user = UserFactory::new()
            ->unverified()
            ->createOne();

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon())->subMinute(), // expires
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
        /** @var User $user */
        $user = UserFactory::new()
            ->unverified()
            ->createOne();

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon())->addMinute(),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertRouteIs('home')
                ->assertSee(__('verification.verified'))
            ;
        });
    }

    private function clearRateLimiter(int $id): void
    {
        app(RateLimiter::class)->clear(sha1((string)$id));
    }
}
