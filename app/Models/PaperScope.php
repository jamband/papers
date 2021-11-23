<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder byUserId(int $userId)
 */
trait PaperScope
{
    /**
     * @noinspection PhpUnused
     * @param Builder $query
     * @param int $userId
     * @return Builder
     */
    public function scopeByUserId(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
