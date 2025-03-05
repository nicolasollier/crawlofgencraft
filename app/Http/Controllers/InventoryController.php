<?php

namespace App\Http\Controllers;

use App\Models\Inventory;

class InventoryController extends Controller
{
    public function equipItem($inventory_id)
    {
        $inventory = Inventory::findOrFail($inventory_id);
        $itemType = $inventory->item->item_type;
    
        if (in_array($itemType, ['weapon', 'armor'])) {
            Inventory::where('character_id', $inventory->character_id)
                ->where('equipped', true)
                ->whereHas('item', function ($query) use ($itemType) {
                    $query->where('item_type', $itemType);
                })
                ->update(['equipped' => false]);
        }

        $inventory->update(['equipped' => true]);
    }

    public function unequipItem($inventory_id)
    {
        $inventory = Inventory::find($inventory_id);
        $inventory->update(['equipped' => false]);
    }
}
