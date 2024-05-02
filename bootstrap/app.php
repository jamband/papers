<?php

declare(strict_types=1);

use App\Groups\Users\User;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\RouteRegistrar;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            /** @var Application $app */
            $app = Application::getInstance()->make(Application::class);
            /** @var RouteRegistrar $router */
            $router = Application::getInstance()->make(RouteRegistrar::class);

            $groups = [
                'Admin',
                'Auth',
                'Users',
                'Papers',
                'Site',
            ];

            foreach ($groups as $group) {
                $router->middleware('web')->group(
                    $app->basePath('app/Groups/'.$group.'/_routes.php')
                );
            }
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (InvalidSignatureException $e, Request $request) {
            /** @var ResponseFactory $response */
            $response = Application::getInstance()->make(ResponseFactory::class);

            /** @var User $user */
            $user = $request->user();

            $data['exception'] = $e;

            if ($request->routeIs('verification.verify') && !$user->hasVerifiedEmail()) {
                $data['title'] = __('verification.verify.title');
                $data['message'] = __('verification.verify.message');
            }

            return $response->view('errors.403', $data, $e->getStatusCode());
        });
    })->create();
