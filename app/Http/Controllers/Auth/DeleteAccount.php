<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DeleteAccount extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'verified', /** @see EnsureEmailIsVerified */
            'auth', /** @see Authenticate */
            'password.confirm', /** @see RequirePassword */
        ]);
    }

    public function view(): View
    {
        return view('auth.delete-account');
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        $id = Auth::id();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        User::query()->find($id)->delete();

        return redirect()
            ->route('home')
            ->with('status', 'Account deletion has been completed.');
    }
}
