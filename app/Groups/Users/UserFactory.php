<?php

declare(strict_types=1);

namespace App\Groups\Users;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    protected static string|null $password;

    public function definition(): array
    {
        /** @var HashManager $hash */
        $hash = Container::getInstance()->make(HashManager::class);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => new Carbon(),
            'password' => static::$password ??= $hash->make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): Factory
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }
}
