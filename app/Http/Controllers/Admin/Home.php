<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use Illuminate\View\View;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'verified', /** @see EnsureEmailIsVerified */
            'auth:admin', /** @see Authenticate */
        ]);
    }

    /**
     * @return View
     */
    public function __invoke(): View
    {
        return view('admin.home');
    }
}
