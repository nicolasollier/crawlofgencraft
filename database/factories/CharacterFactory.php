<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->name(),
            'hp' => fake()->numberBetween(1, 100),
            'mana' => fake()->numberBetween(1, 100),
            'gold' => fake()->numberBetween(1, 100),
            'strength' => fake()->numberBetween(1, 100),
            'agility' => fake()->numberBetween(1, 100),
            'intelligence' => fake()->numberBetween(1, 100),
        ];
    }
}
