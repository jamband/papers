<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response;

readonly class RedirectIfAuthenticated
{
    public function __construct(
        private AuthManager $auth,
        private Redirector $redirect,
    ) {
    }

    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return 'admin' === $guard
                    ? $this->redirect->route('admin.home')
                    : $this->redirect->route('home');
            }
        }

        return $next($request);
    }
}
