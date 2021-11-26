<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class AdminUserFactory extends Factory
{
    #[ArrayShape([
        'name' => "string",
        'email' => "string",
        'email_verified_at' => Carbon::class,
        'password' => "string",
        'remember_token' => "string"
    ])] public function definition(): array
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
