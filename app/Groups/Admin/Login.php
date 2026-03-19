<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('guest')]
readonly class Login
{
    public function __construct(
        private Redirector $redirect,
    ) {
    }

    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return $this->redirect->route('admin.home')
            ->with('status', 'Logged in successfully.');
    }
}
