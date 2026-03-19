<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

#[Middleware('guest')]
readonly class ResetPassword
{
    public function __construct(
        private PasswordBroker $password,
        private HashManager $hash,
        private Dispatcher $event,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(ResetPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $status = $this->password->reset($data, function (User $user) use ($data) {
            $user->password = $this->hash->make($data['password']);
            $user->remember_token = Str::random(60);
            $user->save();

            $this->event->dispatch(new PasswordReset($user));
        });

        if ($status === $this->password::PASSWORD_RESET) {
            return $this->redirect->route('auth.login')
                ->with('status', __($status));
        }

        return $this->redirect->back()
            ->withInput(['email' => $data['email']])
            ->withErrors(['email' => __($status)]);
    }
}
