<?php

declare(strict_types=1);

namespace App\Groups\Admin;

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
        $this->middleware('verified');
        $this->middleware('auth:admin');
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
