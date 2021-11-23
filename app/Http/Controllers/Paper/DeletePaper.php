<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use Illuminate\Http\RedirectResponse;

class DeletePaper extends Controller
{
    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        $this->findModel($id)->delete();

        return redirect()->route('paper.home');
    }
}
