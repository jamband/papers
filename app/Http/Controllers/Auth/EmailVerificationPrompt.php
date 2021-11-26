<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPrompt extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth', /** @see Authenticate */
        ]);
    }

    public function __invoke(Request $request): RedirectResponse|View
    {
        /** @var MustVerifyEmail $user */
        $user = $request->user();

        return $user->hasVerifiedEmail()
            ? redirect()->intended()
            : view('auth.verify-email');
    }
}
