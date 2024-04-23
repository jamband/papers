<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use App\Groups\Users\User;
use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class GetUsers extends Controller
{
    public function __construct(
        private readonly User $user,
        private readonly Factory $view,
    ) {
        $this->middleware('auth:admin');
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
