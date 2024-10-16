<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Character;
use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create users with characters
        User::factory()->count(10)->create()->each(function ($user) {
            $user->characters()->saveMany(Character::factory()->count(2)->make());
        });

        // Create items
        Item::factory()->count(50)->create();

        // Create inventory entries
        Character::all()->each(function ($character) {
            $items = Item::inRandomOrder()->take(rand(1, 5))->get();
            foreach ($items as $item) {
                Inventory::factory()->create([
                    'character_id' => $character->id,
                    'item_id' => $item->id,
                ]);
            }
        });
    }
}
