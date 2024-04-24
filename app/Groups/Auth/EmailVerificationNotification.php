<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class EmailVerificationNotification extends Controller
{
    public function __construct(
        private readonly Redirector $redirect,
    ) {
        $this->middleware('auth');
        $this->middleware('throttle:6,1');
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
