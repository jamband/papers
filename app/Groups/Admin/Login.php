<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class Login extends Controller
{
    public function __construct(
        private readonly Redirector $redirect,
    ) {
        $this->middleware('guest');
    }

    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirect->route('admin.home')
            ->with('status', 'Logged in successfully.');
    }
}
