<?php

declare(strict_types=1);

use App\Http\Controllers\Site\Fallback;
use App\Http\Controllers\Site\GetUserProfile;
use Illuminate\Support\Facades\Route;

Route::view('/', 'site.home')->name('home');

Route::view('/about', 'site.about')->name('about');

Route::view('/contact', 'site.contact')->name('contact');

Route::get('/profile', GetUserProfile::class)->name('profile');

Route::fallback(Fallback::class);
