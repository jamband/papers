<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): string|null
    {
        if (!$request->expectsJson()) {
            return $request->routeIs('admin.*', '*.admin')
                ? route('admin.login')
                : route('auth.login');
        }

        return null;
    }
}
