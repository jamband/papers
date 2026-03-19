<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class GetPapers
{
    public function __construct(
        private Paper $paper,
        private Factory $view,
        private AuthManager $auth,
    ) {
    }

    public function __invoke(Request $request): View
    {
        /** @var Paper $query */
        $query = $this->paper::query();

        $papers = $query->byUserId($this->auth->id())
            ->latest()
            ->get();

        return $this->view->make('papers.home', [
            'papers' => $papers,
        ]);
    }
}
