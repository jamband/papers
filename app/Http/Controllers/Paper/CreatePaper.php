<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use App\Http\Requests\Paper\CreateRequest;
use App\Models\Paper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreatePaper extends Controller
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view("papers.create");
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function create(CreateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $paper = new Paper;
        $paper->user_id = Auth::id();
        $paper->title = $data['title'];
        $paper->body = $data['body'];
        $paper->save();

        return redirect()->route('paper.view', [$paper]);
    }
}
