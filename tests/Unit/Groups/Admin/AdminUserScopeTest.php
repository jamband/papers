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
    private AdminUserFactory $adminUserFactory;

    protected function setup(): void
    {
        parent::setUp();

        $this->adminUser = new AdminUser();
        $this->adminUserFactory = new AdminUserFactory();
    }

    public function testInvalidByEmail(): void
    {
        $this->adminUserFactory
            ->createOne();

        $this->assertFalse($this->adminUser->byEmail('foo@example.com')->exists());
    }

    public function testByEmail(): void
    {
        $adminUser = $this->adminUserFactory
            ->createOne();

        $this->adminUserFactory
            ->count(3)->state(new Sequence(
                ['email' => 'foo@example.com'],
                ['email' => 'bar@example.com'],
                ['email' => 'baz@example.com'],
            ))
            ->create();

        $this->assertSame(1, $this->adminUser->byEmail($adminUser->email)->count());
    }
}
