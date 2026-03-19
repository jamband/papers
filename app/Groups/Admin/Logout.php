<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('verified')]
#[Middleware('auth:admin')]
readonly class Logout
{
    public function __construct(
        private AuthManager $auth,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $this->auth->guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->redirect->route('home')
            ->with('status', 'Logged out successfully.');
    }
}
