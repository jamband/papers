<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\{
    Home,
    Login,
    Logout};
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('admin.home');

Route::get('/login', [Login::class, 'view'])->name('admin.login');
Route::post('/login', [Login::class, 'login']);

Route::post('/logout', Logout::class)->name('admin.logout');
