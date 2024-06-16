<?php

namespace Database\Factories;

use App\Models\Level;
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
        if (Level::count() === 0) {
            Level::factory()->create();
        }

        return [
            'full_name' => $this->faker->name(),
            'code' => $this->faker->ean8(),
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->email(),
            'level_id' => Level::inRandomOrder()->first()->id,
        ];
    }
}
