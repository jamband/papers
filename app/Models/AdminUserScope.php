<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder byEmail(string $email)
 */
trait AdminUserScope
{
    /**
     * @noinspection PhpUnused
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

}
