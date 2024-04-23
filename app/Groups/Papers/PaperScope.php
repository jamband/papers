<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder byUserId(int $userId)
 */
trait PaperScope
{
    /**
     * @noinspection PhpUnused
     */
    public function scopeByUserId(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
