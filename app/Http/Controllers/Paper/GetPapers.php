<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GetPapers extends Controller
{
    public function __invoke(Request $request): View
    {
        /** @var Paper $query */
        $query = Paper::query();

        $papers = $query->byUserId(Auth::id())
            ->latest()
            ->get();

        return view('papers.home', [
            'papers' => $papers,
        ]);
    }
}
