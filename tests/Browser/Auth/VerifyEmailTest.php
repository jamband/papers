<?php

declare(strict_types=1);

namespace Tests\Browser\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class VerifyEmailTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws Throwable
     */
    public function testVerifyEmailWhenUsedInvalidHash(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon)->addMinute(),
                ['id' => $user->id, 'hash' => 'invalid_hash']
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertSee(__('Forbidden'))
                ->assertSee('This action is unauthorized.')
            ;
        });
    }

    /**
     * @throws Throwable
     */
    public function testVerifyEmailWhenExpires(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon)->subMinute(), // expires
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->assertSee(__('verification.verify.title'))
                ->assertSee(__('verification.verify.message'))
            ;
        });
    }

    /**
     * @throws Throwable
     */
    public function testVerifyEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->clearRateLimiter($user->id);

        $this->browse(function (Browser $browser) use ($user) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                (new Carbon)->addMinute(),
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
