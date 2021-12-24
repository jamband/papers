<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class DeleteUser extends Controller
{
    public function __construct()
    {
        parent::__construct();

        /** @see Authenticate */
        $this->middleware('auth:admin');
    }

    public function __invoke(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        $user->delete();

        return redirect()->route('admin.users')
            ->with('status', $user->name.' has been deleted.');
    }
}
