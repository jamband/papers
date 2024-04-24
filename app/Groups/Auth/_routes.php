<?php

declare(strict_types=1);

namespace App\Groups\Auth;

use Illuminate\Routing\RouteRegistrar;

/** @var RouteRegistrar $router */
$router->get('/register', RegisterView::class)->name('auth.register');
$router->post('/register', Register::class);

$router->get('/login', LoginView::class)->name('auth.login');
$router->post('/login', Login::class);

$router->post('/logout', Logout::class)->name('auth.logout');

$router->get('/forgot-password', ForgotPasswordView::class)->name('password.forgot');
$router->post('/forgot-password', ForgotPassword::class);

$router->get('/reset-password/{token}', ResetPasswordView::class)->name('password.reset');
$router->post('/reset-password', ResetPassword::class)->name('password.update');

$router->get('/email/verify', EmailVerificationPrompt::class)->name('verification.notice');
$router->get('/email/verify/{id}/{hash}', VerifyEmail::class)->name('verification.verify');
$router->post('/email/verification-notification', EmailVerificationNotification::class)->name('verification.send');

$router->get('/confirm-password', ConfirmPasswordView::class)->name('password.confirm');
$router->post('/confirm-password', ConfirmPassword::class);

$router->get('/delete-account', DeleteAccountView::class)->name('auth.delete');
$router->post('/delete-account', DeleteAccount::class);
