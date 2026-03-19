<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('auth')]
readonly class ConfirmPasswordView
{
    public function __construct(
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        return $this->view->make('auth.confirm-password');
    }
}
