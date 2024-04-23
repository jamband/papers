<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestMiddleware(): void
    {
        $this->actingAs(UserFactory::new()->createOne())
            ->get(route('auth.register'))
            ->assertRedirect(route('home'));

        $this->actingAs(UserFactory::new()->createOne())
            ->post(route('auth.register'))
            ->assertRedirect(route('home'));
    }

    public function testView(): void
    {
        $this->get(route('auth.register'))
            ->assertOk();
    }

    public function testRegister(): void
    {
        Event::fake();

        $data['name'] = 'foo';
        $data['email'] = 'foo@example.com';
        $data['password'] = str_repeat($data['name'], 3);
        $data['password_confirmation'] = $data['password'];

        $this->post(route('auth.register'), $data)
            ->assertRedirect(route('verification.notice'));

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticated();
    }
}
