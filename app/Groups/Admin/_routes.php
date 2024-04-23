<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;

/** @var RouteRegistrar $router */
$router->prefix('admin')->group(function (Router $router) {
    $router->pattern('id', '[\d]+');

    $router->get('/', Home::class)->name('admin.home');
    $router->get('/login', LoginView::class)->name('admin.login');
    $router->post('/login', Login::class);
    $router->post('/logout', Logout::class)->name('admin.logout');
    $router->get('/users', GetUsers::class)->name('admin.users');
    $router->post('/users/{id}/delete', DeleteUser::class)->name('admin.user.delete');
});
