<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => implode(" ", (array) fake()->sentences(6)),
            'deadline_at' => fake()->dateTimeInInterval('+1 days', '+1 week')->format('Y-m-d H:i:s')
        ];
    }
}
