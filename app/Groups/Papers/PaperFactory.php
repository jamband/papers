<?php

declare(strict_types=1);

namespace App\Groups\Papers;

use App\Groups\Users\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Paper>
 */
class PaperFactory extends Factory
{
    protected $model = Paper::class;

    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
        ];
    }
}
