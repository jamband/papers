<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmPassword extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth', /** @see Authenticate */
        ]);
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function confirmPassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (!Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $request->input('password'),
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended();
    }
}
