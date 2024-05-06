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
        $userFactory = new UserFactory();

        return [
            'user_id' => $userFactory,
            'title' => $this->faker->sentence(3),
            'body' => $this->faker->paragraph(),
        ];
    }
}
