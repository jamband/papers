<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use Illuminate\View\View;

class GetPaper extends Controller
{
    /**
     * @param int $id
     * @return View
     */
    public function __invoke(int $id): View
    {
        return view('papers.view', [
            'paper' => $this->findModel($id),
        ]);
    }
}
