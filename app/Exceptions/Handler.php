<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (InvalidSignatureException $e, Request $request) {
            $data['exception'] = $e;

            if ($request->routeIs('verification.verify') && !$request->user()->hasVerifiedEmail()) {
                $data['title'] = __('verification.verify.title');
                $data['message'] = __('verification.verify.message');
            }

            return response()->view('errors.403', $data, $e->getStatusCode());
        });

        $this->reportable(function (Throwable $e) {
        });
    }
}
