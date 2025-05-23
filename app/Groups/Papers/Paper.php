<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property string $created_at
 * @property string $updated_at
 *
 * @mixin Builder<self>
 */
class Paper extends Model
{
    use PaperScope;

    private const string CREATED_AT_FORMAT = 'F jS Y, g:i a';
    private const string UPDATED_AT_FORMAT = self::CREATED_AT_FORMAT;

    public function createdAt(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value): string => Carbon::parse($value)->format(self::CREATED_AT_FORMAT),
        );
    }

    public function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value): string => Carbon::parse($value)->format(self::UPDATED_AT_FORMAT),
        );
    }
}
