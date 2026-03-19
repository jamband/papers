<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('guest')]
readonly class Register
{
    public function __construct(
        private User $user,
        private HashManager $hash,
        private AuthManager $auth,
        private Dispatcher $event,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->password = $this->hash->make($data['password']);
        $this->user->save();

        $this->event->dispatch(new Registered($this->user));

        $this->auth->login($this->user);

        return $this->redirect->route('verification.notice');
    }
}
