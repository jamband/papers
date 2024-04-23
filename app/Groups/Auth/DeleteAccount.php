<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory;
use Illuminate\View\View;

class DeleteAccount extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly AuthManager $auth,
        private readonly User $user,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
        $this->middleware('password.confirm');
    }

    public function view(): View
    {
        return $this->view->make('auth.delete-account');
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        $id = $this->auth->id();
        $this->auth->guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->user::query()->find($id)->delete();

        return $this->redirect
            ->route('home')
            ->with('status', 'Account deletion has been completed.');
    }
}
