<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create()->each(function ($user) {
            $user->characters()->saveMany(Character::factory()->count(2)->make());
        });

        Item::factory()->count(30)->create();

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
