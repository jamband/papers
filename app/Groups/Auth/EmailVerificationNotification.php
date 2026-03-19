<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('auth')]
#[Middleware('throttle:6,1')]
readonly class EmailVerificationNotification
{
    public function __construct(
        private Redirector $redirect,
    ) {
    }

    public function __invoke(Request $request): RedirectResponse
    {
        /** @var MustVerifyEmail $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->redirect->intended();
        }

        $user->sendEmailVerificationNotification();

        return $this->redirect->back()
            ->with('status', 'verification-link-sent');
    }
}
