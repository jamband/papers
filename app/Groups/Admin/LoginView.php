<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('guest')]
readonly class LoginView
{
    public function __construct(
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        return $this->view->make('admin.login');
    }
}
