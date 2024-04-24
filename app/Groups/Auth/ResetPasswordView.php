<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ResetPasswordView extends Controller
{
    public function __construct(
        private readonly Factory $view,
    ) {
        $this->middleware('guest');
    }

    public function __invoke(Request $request): View
    {
        return $this->view->make('auth.reset-password', [
            'token' => $request->route('token'),
            'email' => $request->input('email'),
        ]);
    }
}
