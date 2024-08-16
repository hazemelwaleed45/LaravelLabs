<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'image' => $this->faker->imageUrl(640, 480, 'people'),
            'grade' => $this->faker->numberBetween(1, 100),
            'track_id' => $this->faker->numberBetween(1, 8),
        ];
    }
}
