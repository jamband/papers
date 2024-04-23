<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ResetPassword extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly PasswordBroker $password,
        private readonly HashManager $hash,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('guest');
    }

    public function view(Request $request): View
    {
        return $this->view->make('auth.reset-password', [
            'token' => $request->route('token'),
            'email' => $request->input('email'),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $status = $this->password->reset($data, function (User $user) use ($data) {
            $user->password = $this->hash->make($data['password']);
            $user->remember_token = Str::random(60);
            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === $this->password::PASSWORD_RESET) {
            return $this->redirect
                ->route('auth.login')
                ->with('status', __($status));
        }

        return $this->redirect
            ->back()
            ->withInput(['email' => $data['email']])
            ->withErrors(['email' => __($status)]);
    }
}
