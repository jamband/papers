<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\View\View;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /** @see EnsureEmailIsVerified */
        $this->middleware('verified');

        /** @see Authenticate */
        $this->middleware('auth:admin');
    }

    public function __invoke(): View
    {
        return view('admin.home');
    }
}
