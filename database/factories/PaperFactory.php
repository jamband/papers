<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @noinspection PhpUnused
 */
class PaperFactory extends Factory
{
    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
        ];
    }
}
