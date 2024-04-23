<?php

declare(strict_types=1);

namespace Tests\Unit\Groups\Users;

use App\Groups\Users\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setup();

        $this->user = new User();
    }

    public function testTimestamps(): void
    {
        $this->assertTrue($this->user->timestamps);
    }
}
