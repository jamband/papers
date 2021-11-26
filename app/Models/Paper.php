<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 */
class Paper extends Model
{
    use HasFactory;
    use PaperScope;

    private const CREATED_AT_FORMAT = 'F jS Y, g:i a';
    private const UPDATED_AT_FORMAT = self::CREATED_AT_FORMAT;

    /**
     * @noinspection PhpUnused
     */
    public function getCreatedAtAttribute(mixed $value): string
    {
        return Carbon::parse($value)->format(self::CREATED_AT_FORMAT);
    }

    /**
     * @noinspection PhpUnused
     */
    public function getUpdatedAtAttribute(mixed $value): string
    {
        return Carbon::parse($value)->format(self::UPDATED_AT_FORMAT);
    }
}
