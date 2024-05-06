<?php

declare(strict_types=1);

namespace App\Groups\Admin;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Str;

/**
 * @extends Factory<AdminUser>
 */
class AdminUserFactory extends Factory
{
    public const PASSWORD = 'adminadmin';

    protected $model = AdminUser::class;

    protected static string|null $password;

    public function definition(): array
    {
        $carbon = new Carbon();
        /** @var HashManager $hash */
        $hash = Container::getInstance()->make(HashManager::class);

        return [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => $carbon,
            'password' => static::$password ??= $hash->make(self::PASSWORD),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @return Factory<AdminUser>
     */
    public function unverified(): Factory
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }
}
