<?php

declare(strict_types=1);

namespace Tests\Unit\Groups\Admin;

use App\Groups\Admin\AdminUser;
use App\Groups\Admin\AdminUserFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserScopeTest extends TestCase
{
    use RefreshDatabase;

    private AdminUser $adminUser;

    protected function setup(): void
    {
        parent::setUp();

        $this->adminUser = new AdminUser();
    }

    public function testInvalidByEmail(): void
    {
        AdminUserFactory::new()
            ->createOne();

        $this->assertFalse($this->adminUser->byEmail('foo@example.com')->exists());
    }

    public function testByEmail(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUserFactory::new()
            ->createOne();

        AdminUserFactory::new()
            ->count(3)->state(new Sequence(
                ['email' => 'foo@example.com'],
                ['email' => 'bar@example.com'],
                ['email' => 'baz@example.com'],
            ))
            ->create();

        $this->assertSame(1, $this->adminUser->byEmail($adminUser->email)->count());
    }
}
