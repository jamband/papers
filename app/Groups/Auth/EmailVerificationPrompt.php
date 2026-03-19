<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('auth')]
readonly class EmailVerificationPrompt
{
    public function __construct(
        private Redirector $redirect,
        private Factory $view,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse|View
    {
        /** @var MustVerifyEmail $user */
        $user = $request->user();

        return $user->hasVerifiedEmail()
            ? $this->redirect->intended()
            : $this->view->make('auth.verify-email');
    }
}
