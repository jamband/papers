<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class RegisterView extends Controller
{
    public function __construct(
        private readonly Factory $view,
    ) {
        $this->middleware('guest');
    }

    public function __invoke(): View
    {
        return $this->view->make('auth.register');
    }
}
