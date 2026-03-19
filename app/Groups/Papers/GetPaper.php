<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class GetPaper
{
    public function __construct(
        private Paper $paper,
        private Factory $view,
        private AuthManager $auth,
    ) {
    }

    public function __invoke(int $id): View
    {
        /** @var Paper $query */
        $query = $this->paper::query();

        $paper = $query->byUserId($this->auth->id())
            ->findOrFail($id);

        return $this->view->make('papers.view', [
            'paper' => $paper,
        ]);
    }
}
