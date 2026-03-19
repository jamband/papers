<?php

declare(strict_types=1);

namespace App\Groups\Users;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('verified')]
#[Middleware('auth')]
readonly class GetUserProfile
{
    public function __construct(
        private AuthManager $auth,
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        /** @var User $user */
        $user = $this->auth->user();

        return $this->view->make('site.profile', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
