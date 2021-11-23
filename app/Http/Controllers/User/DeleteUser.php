<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class DeleteUser extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware([
            'auth:admin', /** @see Authenticate */
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function __invoke(int $id): RedirectResponse
    {
        /** @var User $user */
        $user = User::query()->findOrFail($id);

        $user->delete();

        return redirect()->route('user.admin')
            ->with('status', $user->name.' has been deleted.');
    }
}
