<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ResetPassword extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'guest', /** @see RedirectIfAuthenticated */
        ]);
    }

    public function view(Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $request->route('token'),
            'email' => $request->input('email'),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $status = Password::reset($data, function (User $user) use ($data) {
            $user->password = Hash::make($data['password']);
            $user->remember_token = Str::random(60);
            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.login')
                ->with('status', __($status));
        }

        return back()->withInput(['email' => $data['email']])
            ->withErrors(['email' => __($status)]);
    }
}
