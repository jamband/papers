<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class CreatePaper extends Controller
{
    public function __construct(
        private readonly Paper $paper,
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->paper->user_id = $this->auth->id();
        $this->paper->title = $data['title'];
        $this->paper->body = $data['body'];
        $this->paper->save();

        return $this->redirect->route('paper.view', [$this->paper]);
    }
}
