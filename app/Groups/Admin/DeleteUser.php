<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use App\Groups\Users\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class DeleteUser extends Controller
{
    public function __construct(
        private readonly User $user,
    ) {
        $this->middleware('auth:admin');
    }

    public function __invoke(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = $this->user::query()
            ->findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users')
            ->with('status', $user->name.' has been deleted.');
    }
}
