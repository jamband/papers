<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Registered;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory;
use Illuminate\View\View;

class Register extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly User $user,
        private readonly HashManager $hash,
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('guest');
    }

    public function view(): View
    {
        return $this->view->make('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->password = $this->hash->make($data['password']);
        $this->user->save();

        event(new Registered($this->user));

        $this->auth->login($this->user);

        return $this->redirect->route('verification.notice');
    }
}
