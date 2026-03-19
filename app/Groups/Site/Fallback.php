<?php

declare(strict_types=1);

namespace App\Groups\Site;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

readonly class Fallback
{
    public function __construct(
        private AuthManager $auth,
        private ResponseFactory $response,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->auth->guard('admin')->check()
            ? $this->response->view('errors.admin.404', [], 404)
            : $this->response->view('errors.404', [], 404);
    }
}
