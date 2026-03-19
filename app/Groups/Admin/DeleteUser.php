<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use App\Groups\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Routing\Redirector;

#[Middleware('auth:admin')]
readonly class DeleteUser
{
    public function __construct(
        private User $user,
        private Redirector $redirect,
    ) {
    }

    public function __invoke(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = $this->user::query()
            ->findOrFail($id);

        $user->delete();

        return $this->redirect->route('admin.users')
            ->with('status', $user->name.' has been deleted.');
    }
}
