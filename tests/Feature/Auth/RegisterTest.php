<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\Register;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/** @see Register */
class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testGuestMiddleware(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('auth.register'))
            ->assertRedirect(route('home'));

        $this->actingAs($user)
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
        $data['email'] = $this->faker->email;
        $data['password'] = str_repeat($data['name'], 3);
        $data['password_confirmation'] = $data['password'];

        $this->post(route('auth.register'), $data)
            ->assertRedirect(route('verification.notice'));

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticated();
    }
}
