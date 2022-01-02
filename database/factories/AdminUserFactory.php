<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => new Carbon,
            'password' => '$2y$10$2agvbzbEtoD1a2gFNcs8LebbM9JNEikFYJodGH7PMgJNO0eRU95uK', // adminadmin
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @noinspection PhpUnused
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
