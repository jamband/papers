<?php

declare(strict_types=1);

namespace App\Groups\Users;

use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Illuminate\View\Factory;
use Illuminate\View\View;

class GetUserProfile extends Controller
{
    public function __construct(
        private readonly AuthManager $auth,
        private readonly Factory $view,
    ) {
        $this->middleware('verified');
        $this->middleware('auth');
    }

    public function __invoke(): View
    {
        $user = $this->auth->user();

        return $this->view->make('site.profile', [
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
