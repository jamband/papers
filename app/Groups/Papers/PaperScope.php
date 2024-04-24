<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method self byUserId(int $userId)
 * @see self::scopeByUserId()
 */
trait PaperScope
{
    /**
     * @param Builder<self> $query
     * @param int $userId
     * @return Builder<self>
     */
    public function scopeByUserId(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
