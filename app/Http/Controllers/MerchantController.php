<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Character;
use App\Models\Inventory;
use App\Models\Item;

class MerchantController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user()->load(['characters.inventory.item', 'characters.dungeon']);
        $characters = $user->characters;

        $dungeons = $characters->pluck('dungeon')->filter()->values();

        return Inertia::render('Merchant', [
            'characters' => $characters,
            'dungeons' => $dungeons,
        ]);
    }

    public function sellItem(Request $request)
    {
        $validated = $request->validate([
            'character_id' => 'required|exists:characters,id',
            'item_id' => 'required|exists:items,id',
        ]);
    
        $character = Character::findOrFail($validated['character_id']);
        $inventory = Inventory::where('character_id', $character->id)
            ->where('item_id', $validated['item_id'])
            ->firstOrFail();
    
        $item = $inventory->item;
        $character->gold += $item->value;
        $character->save();
        $inventory->delete();
    
        return back()->with('success', "Vous avez vendu {$item->name} pour {$item->value} pièces d'or.");
    }
}
