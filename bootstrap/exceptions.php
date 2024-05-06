<?php

declare(strict_types=1);

use App\Groups\Users\User;
use Illuminate\Container\Container;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\ResponseFactory;

return function (Exceptions $exceptions) {
    $exceptions->render(function (Throwable $e, Request $request) {
        /** @var ResponseFactory $response */
        $response = Container::getInstance()->make(ResponseFactory::class);

        if ($e instanceof InvalidSignatureException) {
            /** @var User $user */
            $user = $request->user();

            $data['exception'] = $e;

            if ($request->routeIs('verification.verify') && !$user->hasVerifiedEmail()) {
                $data['title'] = __('verification.verify.title');
                $data['message'] = __('verification.verify.message');
            }

            return $response->view('errors.403', $data, $e->getStatusCode());
        }

        return null;
    });
};
