<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class GetPapers extends Controller
{
    public function __construct(
        private readonly Factory $view,
        private readonly AuthManager $auth,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(Request $request): View
    {
        /** @var Paper $query */
        $query = Paper::query();

        $papers = $query->byUserId($this->auth->id())
            ->latest()
            ->get();

        return $this->view->make('papers.home', [
            'papers' => $papers,
        ]);
    }
}
