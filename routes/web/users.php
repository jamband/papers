<?php

declare(strict_types=1);

use App\Http\Controllers\User\{
    DeleteUser,
    ManageUsers};
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[\d]+');

Route::get('admin', ManageUsers::class)->name('user.admin');

Route::post('{id}/delete', DeleteUser::class)->name('user.delete');
