<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use App\Groups\Users\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class VerifyEmail extends Controller
{
    public function __construct(
        private readonly Redirector $redirect,
        private readonly Dispatcher $event,
    ) {
        $this->middleware('auth');
        $this->middleware('signed');
        $this->middleware('throttle:6,1');
    }

    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->redirect->route('home');
        }

        if ($user->markEmailAsVerified()) {
            $this->event->dispatch(new Verified($user));
        }

        return $this->redirect->route('home')
            ->with('status', 'User registration has been completed.');
    }
}
