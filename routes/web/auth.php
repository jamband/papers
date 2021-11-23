<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\{
    ConfirmPassword,
    DeleteAccount,
    EmailVerificationNotification,
    EmailVerificationPrompt,
    ForgotPassword,
    Login,
    Logout,
    Register,
    ResetPassword,
    VerifyEmail};
use Illuminate\Support\Facades\Route;

Route::get('/register', [Register::class, 'view'])->name('auth.register');
Route::post('/register', [Register::class, 'register']);

Route::get('/login', [Login::class, 'view'])->name('auth.login');
Route::post('/login', [Login::class, 'login']);

Route::post('/logout', Logout::class)->name('auth.logout');

Route::get('/forgot-password', [ForgotPassword::class, 'view'])->name('password.forgot');
Route::post('/forgot-password', [ForgotPassword::class, 'forgotPassword']);

Route::get('/reset-password/{token}', [ResetPassword::class, 'view'])->name('password.reset');
Route::post('/reset-password', [ResetPassword::class, 'resetPassword'])->name('password.update');

Route::get('/email/verify', EmailVerificationPrompt::class)->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
Route::post('/email/verification-notification', EmailVerificationNotification::class)->name('verification.send');

Route::get('/confirm-password', [ConfirmPassword::class, 'view'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmPassword::class, 'confirmPassword']);

Route::get('/delete-account', [DeleteAccount::class, 'view'])->name('auth.delete');
Route::post('/delete-account', [DeleteAccount::class, 'deleteAccount']);
