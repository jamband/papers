<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestMiddleware(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $this->actingAs($adminUser)
            ->get(route('admin.login'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('admin.login'))
            ->assertOk();
    }

    public function testLoginFails(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $data['email'] = $adminUser->email;
        $data['password'] = 'wrong_password';

        $this->post(route('admin.login'), $data);

        $this->assertGuest('admin');
    }

    public function testLogin(): void
    {
        /** @var AdminUser $adminUser */
        $adminUser = AdminUser::factory()->create();

        $data['email'] = $adminUser->email;
        $data['password'] = str_repeat($adminUser->name, 2);

        $this->post(route('admin.login'), $data)
            ->assertRedirect(route('admin.home'));

        $this->assertAuthenticated('admin');
    }
}
