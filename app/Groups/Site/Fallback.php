<?php

declare(strict_types=1);

namespace App\Groups\Site;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;

class Fallback extends Controller
{
    public function __construct(
        private readonly AuthManager $auth,
        private readonly ResponseFactory $response,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->auth->guard('admin')->check()
            ? $this->response->view('errors.admin.404', [], 404)
            : $this->response->view('errors.404', [], 404);
    }
}
