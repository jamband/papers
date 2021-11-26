<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use App\Http\Requests\Paper\UpdateRequest;
use App\Models\Paper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UpdatePaper extends Controller
{
    public function view(int $id): View
    {
        return view("papers.update", [
            'paper' => $this->findModel($id),
        ]);
    }

    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        /** @var Paper $paper */
        $paper = $this->findModel($id);
        $paper->user_id = Auth::id();
        $paper->title = $data['title'];
        $paper->body = $data['body'];
        $paper->save();

        return redirect()->route('paper.view', [$paper]);
    }
}
