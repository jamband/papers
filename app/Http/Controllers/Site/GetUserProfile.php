<?php

declare(strict_types=1);

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GetUserProfile extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'verified', /** @see EnsureEmailIsVerified */
            'auth', /** @see Authenticate */
        ]);
    }

    /**
     * @return View
     */
    public function __invoke(): View
    {
        $user = Auth::user();

        return view('site.profile', [
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
