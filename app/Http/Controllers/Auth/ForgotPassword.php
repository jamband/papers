<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPassword extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /** @see RedirectIfAuthenticated */
        $this->middleware('guest');
    }

    public function view(): View
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $status = Password::sendResetLink($data);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withInput($data)
            ->withErrors(['email' => __($status)]);
    }
}
