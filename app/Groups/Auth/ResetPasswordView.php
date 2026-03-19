<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('guest')]
readonly class ResetPasswordView
{
    public function __construct(
        private Factory $view,
    ) {
    }

    public function __invoke(Request $request): View
    {
        return $this->view->make('auth.reset-password', [
            'token' => $request->route('token'),
            'email' => $request->input('email'),
        ]);
    }
}
