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
use Illuminate\View\Factory;
use Illuminate\View\View;

class ConfirmPassword extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('auth');
        $this->middleware('throttle:6,1');
    }

    public function view(): View
    {
        return $this->view->make('auth.confirm-password');
    }

    public function confirmPassword(Request $request): RedirectResponse
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
