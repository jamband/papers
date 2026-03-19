<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('verified')]
#[Middleware('auth:admin')]
readonly class Home
{
    public function __construct(
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        return $this->view->make('admin.home');
    }
}
