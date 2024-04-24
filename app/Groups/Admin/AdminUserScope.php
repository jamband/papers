<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method self byEmail(string $email)
 * @see self::scopeByEmail())
 */
trait AdminUserScope
{
    /**
     * @param Builder<self> $query
     * @param string $email
     * @return Builder<self>
     */
    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

}
