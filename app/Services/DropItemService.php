<?php

namespace App\Services;

use App\Models\Item;

class DropItemService
{
    private const RARITY_WEIGHTS = [
        'common' => 50,
        'uncommon' => 25,
        'rare' => 15,
        'epic' => 8,
        'legendary' => 2,
    ];

    public function determineRarity(): string
    {
        $total = array_sum(self::RARITY_WEIGHTS);
        $roll = rand(1, $total);
        $currentTotal = 0;

        foreach (self::RARITY_WEIGHTS as $rarity => $weight) {
            $currentTotal += $weight;
            if ($roll <= $currentTotal) {
                return $rarity;
            }
        }

        return 'common';
    }

    public function dropItem(bool $isSuccess): ?Item
    {
        if (! $isSuccess) {
            return null;
        }

        $rarity = $this->determineRarity();
        $items = config('items');
        $itemType = rand(0, 1) === 0 ? 'weapon' : 'armor';
        $itemPool = $items[$itemType.'s'][$rarity];
        $selectedItem = $itemPool[array_rand($itemPool)];

        return Item::create([
            'name' => $selectedItem['name'],
            'description' => $selectedItem['description'],
            'item_type' => $itemType,
            'damage_bonus' => $itemType === 'weapon' ? $selectedItem['damage_bonus'] : 0,
            'armor_bonus' => $itemType === 'armor' ? $selectedItem['armor_bonus'] : 0,
            'value' => $selectedItem['value'],
            'rarity' => $rarity,
        ]);
    }
}
