<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class CreatePaperView
{
    public function __construct(
        private Factory $view
    ) {
    }

    public function __invoke(): View
    {
        return $this->view->make("papers.create");
    }
}
