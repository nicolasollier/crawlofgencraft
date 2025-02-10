<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = config('items');
        $itemType = $this->faker->randomElement(['weapons', 'armors']);
        $rarity = $this->faker->randomElement(['common', 'uncommon', 'rare', 'epic', 'legendary']);
        
        $item = $this->faker->randomElement($items[$itemType][$rarity]);

        return [
            'name' => $item['name'],
            'item_type' => $item['item_type'],
            'description' => $item['description'],
            'value' => $item['value'],
            'damage_bonus' => $item['item_type'] === 'weapon' ? $item['damage_bonus'] : 0,
            'armor_bonus' => $item['item_type'] === 'armor' ? $item['armor_bonus'] : 0,
            'rarity' => $rarity,
        ];
    }

    /**
     * Configure the factory to generate weapons only.
     */
    public function weapon(): static
    {
        return $this->state(function () {
            $weapons = config('items.weapons');
            $rarity = $this->faker->randomElement(['common', 'uncommon', 'rare', 'epic', 'legendary']);
            $weapon = $this->faker->randomElement($weapons[$rarity]);

            return [
                'name' => $weapon['name'],
                'item_type' => 'weapon',
                'description' => $weapon['description'],
                'value' => $weapon['value'],
                'damage_bonus' => $weapon['damage_bonus'],
                'armor_bonus' => 0,
                'rarity' => $rarity,
            ];
        });
    }

    /**
     * Configure the factory to generate armors only.
     */
    public function armor(): static
    {
        return $this->state(function () {
            $armors = config('items.armors');
            $rarity = $this->faker->randomElement(['common', 'uncommon', 'rare', 'epic', 'legendary']);
            $armor = $this->faker->randomElement($armors[$rarity]);

            return [
                'name' => $armor['name'],
                'item_type' => 'armor',
                'description' => $armor['description'],
                'value' => $armor['value'],
                'damage_bonus' => 0,
                'armor_bonus' => $armor['armor_bonus'],
                'rarity' => $rarity,
            ];
        });
    }
}
