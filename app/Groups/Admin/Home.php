<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class Home extends Controller
{
    public function __construct(
        private readonly Factory $view,
    ) {
        $this->middleware('verified');
        $this->middleware('auth:admin');
    }

    public function __invoke(): View
    {
        return $this->view->make('admin.home');
    }
}
