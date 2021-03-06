<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\View\View;

class GetUsers extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /** @see Authenticate */
        $this->middleware('auth:admin');
    }

    public function __invoke(): View
    {
        $users = User::query()->latest()->get();

        return view('admin.users', [
            'users' => $users,
        ]);
    }
}
