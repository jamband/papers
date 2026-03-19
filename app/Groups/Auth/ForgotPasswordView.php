<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('guest')]
readonly class ForgotPasswordView
{
    public function __construct(
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        return $this->view->make('auth.forgot-password');
    }
}
