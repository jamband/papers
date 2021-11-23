<?php

declare(strict_types=1);

use App\Http\Controllers\Paper\{
    CreatePaper,
    DeletePaper,
    GetPaper,
    GetPapers,
    UpdatePaper};
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[\d]+');

Route::get('', GetPapers::class)->name('paper.home');

Route::get('{id}', GetPaper::class)->name('paper.view');

Route::get('create', [CreatePaper::class, 'view'])->name('paper.create');
Route::post('create', [CreatePaper::class, 'create']);

Route::get('{id}/update', [UpdatePaper::class, 'view'])->name('paper.update');
Route::post('{id}/update', [UpdatePaper::class, 'update']);

Route::post('{id}/delete', DeletePaper::class)->name('paper.delete');
