<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;

class VerifyEmail extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth', /** @see Authenticate */
            'signed', /** @see ValidateSignature */
            'throttle:6,1', /** @see ThrottleRequests */
        ]);
    }

    /**
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('home')
            ->with('status', 'User registration has been completed.');
    }
}
