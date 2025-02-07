<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $target_id = Random::generate(1, '0-4');
        if(!$target_id)
            $target_id = null;

        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'due_date' => fake()->dateTimeBetween('now', '+5 days'),
            'status' => Random::generate(1, '0-2'),
            'owner_id' => Random::generate(1, '1-4'),
            'target_id' => $target_id
        ];
    }
}
