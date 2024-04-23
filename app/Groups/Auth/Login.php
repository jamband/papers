<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory;
use Illuminate\View\View;

class Login extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('guest');
    }

    public function view(): View
    {
        return $this->view->make('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirect
            ->intended()
            ->with('status', 'Logged in.');
    }
}
