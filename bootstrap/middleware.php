<?php

declare(strict_types=1);

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Configuration\Middleware;

return function (Middleware $middleware) {
    $middleware->alias([
        'auth' => Authenticate::class,
        'guest' => RedirectIfAuthenticated::class,
    ]);
};
