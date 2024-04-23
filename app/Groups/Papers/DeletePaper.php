<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class DeletePaper extends Controller
{
    public function __construct(
        private readonly Paper $paper,
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
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
