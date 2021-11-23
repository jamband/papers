<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return $request->routeIs('admin.*', '*.admin')
                ? route('admin.login')
                : route('auth.login');
        }

        return null;
    }
}
