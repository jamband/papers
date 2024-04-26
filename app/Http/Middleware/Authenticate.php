<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Routing\UrlGenerator;

class Authenticate extends Middleware
{
    public function __construct(
        Auth $auth,
        private readonly UrlGenerator $url,
    ) {
        parent::__construct($auth);
    }

    protected function redirectTo($request): string|null
    {
        if (!$request->expectsJson()) {
            return $request->routeIs('admin.*', '*.admin')
                ? $this->url->route('admin.login')
                : $this->url->route('auth.login');
        }

        return null;
    }
}
