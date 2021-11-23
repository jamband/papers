<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @noinspection PhpUnused
 */
class AdminUserFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$2agvbzbEtoD1a2gFNcs8LebbM9JNEikFYJodGH7PMgJNO0eRU95uK', // adminadmin
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @noinspection PhpUnused
     * @return Factory
     */
    public function unverified(): Factory
    {
        return $this->state(function () {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
