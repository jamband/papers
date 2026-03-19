<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('verified')]
#[Middleware('auth')]
#[Middleware('password.confirm')]
readonly class DeleteAccount
{
    public function __construct(
        private AuthManager $auth,
        private User $user,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $id = $this->auth->id();
        $this->auth->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->user::query()
            ->find($id)
            ->delete();

        return $this->redirect->route('home')
            ->with('status', 'Account deletion has been completed.');
    }
}
