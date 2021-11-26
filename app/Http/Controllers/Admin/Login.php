<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\Admin\LoginRequest;
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
        return view('admin.login');
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->route('admin.home')
            ->with('status', 'Logged in.');
    }
}
