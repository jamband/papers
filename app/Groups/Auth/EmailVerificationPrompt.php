<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory;
use Illuminate\View\View;

class EmailVerificationPrompt extends Controller
{
    public function __construct(
        private readonly Redirector $redirect,
        private readonly Factory $view,
    ) {
        $this->middleware('auth');
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
