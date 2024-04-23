<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;

class UpdatePaper extends Controller
{
    public function __construct(
        private readonly Paper $paper,
        private readonly AuthManager $auth,
        private readonly Redirector $redirect,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(UpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        /** @var Paper $query */
        $query = $this->paper::query();

        /** @var Paper $paper */
        $paper = $query->byUserId($this->auth->id())->findOrFail($id);
        $paper->user_id = $this->auth->id();
        $paper->title = $data['title'];
        $paper->body = $data['body'];
        $paper->save();

        return $this->redirect->route('paper.view', [$paper]);
    }
}
