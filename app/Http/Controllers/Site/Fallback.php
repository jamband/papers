<?php

declare(strict_types=1);

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Fallback extends Controller
{
    public function __invoke(): Response
    {
        return Auth::guard('admin')->check()
            ? response()->view('errors.admin.404', [], 404)
            : response()->view('errors.404', [], 404);

    }
}
