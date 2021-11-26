<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'guest', /** @see RedirectIfAuthenticated */
        ]);
    }

    public function view(): View
    {
        return view('auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended()
            ->with('status', 'Logged in.');
    }
}
