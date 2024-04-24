<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class ForgotPassword extends Controller
{
    public function __construct(
        private readonly PasswordBroker $password,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('guest');
    }

    public function __invoke(ForgotPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $status = $this->password->sendResetLink($data);

        if ($status === $this->password::RESET_LINK_SENT) {
            return $this->redirect->back()
                ->with('status', __($status));
        }

        return $this->redirect->back()
            ->withInput($data)
            ->withErrors(['email' => __($status)]);
    }
}
