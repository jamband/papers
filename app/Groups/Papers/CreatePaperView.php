<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class CreatePaperView extends Controller
{
    public function __construct(
        private readonly Factory $view
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(): View
    {
        return $this->view->make("papers.create");
    }
}
