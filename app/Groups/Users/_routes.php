<?php

declare(strict_types=1);

namespace App\Groups\Users;

use Illuminate\Routing\RouteRegistrar;

/** @var RouteRegistrar $router */
$router->get('/profile', GetUserProfile::class)->name('profile');
