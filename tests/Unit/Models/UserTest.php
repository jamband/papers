<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see User */
class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testTimestamps(): void
    {
        $user = new User;
        $user->name = 'foo';
        $user->email = 'foo@example.com';
        $user->email_verified_at = new Carbon;
        $user->password = '$2y$04$8ihtuYjlhwreZwU.YXI83.CPVsNwsk8pcx5XA.dhq8qZn5X92TpYG'; // foofoofoo
        $user->save();

        $this->assertInstanceOf(Carbon::class, $user->created_at);
        $this->assertInstanceOf(Carbon::class, $user->updated_at);
    }
}
