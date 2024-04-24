<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ConfirmPasswordView extends Controller
{
    public function __construct(
        private readonly Factory $view,
    ) {
        $this->middleware('auth');
    }

    public function __invoke(): View
    {
        return $this->view->make('auth.confirm-password');
    }
}
