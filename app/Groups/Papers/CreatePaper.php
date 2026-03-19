<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class CreatePaper
{
    public function __construct(
        private Paper $paper,
        private AuthManager $auth,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->paper->user_id = $this->auth->id();
        $this->paper->title = $data['title'];
        $this->paper->body = $data['body'];
        $this->paper->save();

        return $this->redirect->route('paper.view', [
            $this->paper
        ]);
    }
}
