<?php

declare(strict_types=1);

namespace Tests\Feature\Groups\Auth;

use App\Groups\Users\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private UserFactory $userFactory;
    private UrlGenerator $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = new UserFactory();
        $this->url = $this->app->make(UrlGenerator::class);
    }

    public function testGuestMiddleware(): void
    {
        $this->actingAs($this->userFactory->makeOne())
            ->get($this->url->route('auth.register'))
            ->assertRedirect($this->url->route('home'));

        $this->actingAs($this->userFactory->makeOne())
            ->post($this->url->route('auth.register'))
            ->assertRedirect($this->url->route('home'));
    }

    public function testView(): void
    {
        $this->get($this->url->route('auth.register'))
            ->assertOk();
    }

    public function testRegister(): void
    {
        Event::fake();

        $this->post($this->url->route('auth.register'), [
            'name' => 'foo',
            'email' => 'foo@example.com',
            'password' => 'foofoofoo',
            'password_confirmation' => 'foofoofoo',
        ])
            ->assertRedirect($this->url->route('verification.notice'));

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticated();
    }
}
