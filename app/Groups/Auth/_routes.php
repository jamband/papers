<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\RouteRegistrar;

/** @var RouteRegistrar $router */
$router->get('/register', [Register::class, 'view'])->name('auth.register');
$router->post('/register', [Register::class, 'register']);

$router->get('/login', [Login::class, 'view'])->name('auth.login');
$router->post('/login', [Login::class, 'login']);

$router->post('/logout', Logout::class)->name('auth.logout');

$router->get('/forgot-password', [ForgotPassword::class, 'view'])->name('password.forgot');
$router->post('/forgot-password', [ForgotPassword::class, 'forgotPassword']);

$router->get('/reset-password/{token}', [ResetPassword::class, 'view'])->name('password.reset');
$router->post('/reset-password', [ResetPassword::class, 'resetPassword'])->name('password.update');

$router->get('/email/verify', EmailVerificationPrompt::class)->name('verification.notice');
$router->get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
$router->post('/email/verification-notification', EmailVerificationNotification::class)->name('verification.send');

$router->get('/confirm-password', [ConfirmPassword::class, 'view'])->name('password.confirm');
$router->post('/confirm-password', [ConfirmPassword::class, 'confirmPassword']);

$router->get('/delete-account', [DeleteAccount::class, 'view'])->name('auth.delete');
$router->post('/delete-account', [DeleteAccount::class, 'deleteAccount']);
