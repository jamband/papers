<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use App\Groups\Users\User;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\Factory;
use Illuminate\View\View;

#[Middleware('auth:admin')]
readonly class GetUsers
{
    public function __construct(
        private User $user,
        private Factory $view,
    ) {
    }

    public function __invoke(): View
    {
        $users = $this->user::query()
            ->latest()
            ->get();

        return $this->view->make('admin.users', [
            'users' => $users,
        ]);
    }
}
