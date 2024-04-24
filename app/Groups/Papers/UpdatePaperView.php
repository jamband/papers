<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class UpdatePaperView extends Controller
{
    public function __construct(
        private readonly Paper $paper,
        private readonly Factory $view,
        private readonly AuthManager $auth,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(int $id): View
    {
        /** @var Paper $query */
        $query = $this->paper::query();

        $paper = $query->byUserId($this->auth->id())
            ->findOrFail($id);

        return $this->view->make("papers.update", [
            'paper' => $paper,
        ]);
    }
}
