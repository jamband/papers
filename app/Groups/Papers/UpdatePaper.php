<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class UpdatePaper
{
    public function __construct(
        private Paper $paper,
        private AuthManager $auth,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(UpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        /** @var Paper $query */
        $query = $this->paper::query();

        /** @var Paper $paper */
        $paper = $query->byUserId($this->auth->id())
            ->findOrFail($id);

        $paper->user_id = $this->auth->id();
        $paper->title = $data['title'];
        $paper->body = $data['body'];
        $paper->save();

        return $this->redirect->route('paper.view', [$paper]);
    }
}
