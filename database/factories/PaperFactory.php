<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PaperFactory extends Factory
{
    #[ArrayShape([
        'user_id' => "int",
        'title' => "string",
        'body' => "string"
    ])] public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
        ];
    }
}
