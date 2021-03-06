<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class EmailVerificationNotification extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /** @see Authenticate */
        $this->middleware('auth');

        /** @see ThrottleRequests */
        $this->middleware('throttle:6,1');
    }

    public function __invoke(Request $request): RedirectResponse
    {
        /** @var MustVerifyEmail $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended();
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
