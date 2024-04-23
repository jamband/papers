<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder byEmail(string $email)
 */
trait AdminUserScope
{
    /**
     * @noinspection PhpUnused
     */
    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

}
