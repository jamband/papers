<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class Logout extends Controller
{
    public function __construct(
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('auth');
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $this->auth->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->redirect
            ->route('home')
            ->with('status', 'Logged out.');
    }
}
