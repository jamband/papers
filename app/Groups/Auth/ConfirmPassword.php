<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class ConfirmPassword extends Controller
{
    public function __construct(
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('auth');
        $this->middleware('throttle:6,1');
    }

    public function __invoke(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (!$this->auth->guard('web')->validate([
            'email' => $user->email,
            'password' => $request->input('password'),
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->passwordConfirmed();

        return $this->redirect->intended();
    }
}
