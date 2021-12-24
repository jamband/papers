<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\{
    DeleteUser,
    GetUsers,
    Home,
    Login,
    Logout};
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[\d]+');

Route::get('/', Home::class)->name('admin.home');

Route::get('/login', [Login::class, 'view'])->name('admin.login');
Route::post('/login', [Login::class, 'login']);

Route::post('/logout', Logout::class)->name('admin.logout');

Route::get('/users', GetUsers::class)->name('admin.users');

Route::post('/users/{id}/delete', DeleteUser::class)->name('admin.user.delete');
