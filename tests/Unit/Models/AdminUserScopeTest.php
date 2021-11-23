<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUserScopeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testInvalidByEmail(): void
    {
        AdminUser::factory()->create();

        $this->assertFalse((new AdminUser)->byEmail($this->faker->email)->exists());
    }

    public function testByEmail(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        AdminUser::factory()->count(5)->make([
            'email' => $this->faker->email,
        ]);

        $this->assertCount(1, (new AdminUser)->byEmail($adminUser->email)->get());
    }
}
