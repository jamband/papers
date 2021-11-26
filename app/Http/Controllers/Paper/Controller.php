<?php

declare(strict_types=1);

namespace App\Http\Controllers\Paper;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Middleware\Authenticate;
use App\Models\Paper;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        /** @see EnsureEmailIsVerified */
        $this->middleware('verified');

        /** @see Authenticate */
        $this->middleware('auth');
    }

    protected function findModel(int $id): Model
    {
        /** @var Paper $query */
        $query = Paper::query();

        return $query->byUserId(Auth::id())->findOrFail($id);
    }
}
