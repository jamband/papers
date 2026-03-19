<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class DeletePaper
{
    public function __construct(
        private Paper $paper,
        private AuthManager $auth,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(int $id): RedirectResponse
    {
        /** @var Paper $query */
        $query = $this->paper::query();

        $query->byUserId($this->auth->id())
            ->findOrFail($id)
            ->delete();

        return $this->redirect->route('paper.home');
    }
}
