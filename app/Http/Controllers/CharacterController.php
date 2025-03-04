<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CharacterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'strength' => 'required|integer|min:5|max:100',
            'agility' => 'required|integer|min:5|max:100',
            'intelligence' => 'required|integer|min:5|max:100',
        ]);

        $character = Character::create([
            'user_id' => Auth::user()->id,
            'dungeon_id' => null,
            'name' => $validated['name'],
            'hp' => 100,
            'mana' => 100,
            'gold' => 0,
            'strength' => $validated['strength'],
            'agility' => $validated['agility'],
            'intelligence' => $validated['intelligence'],
        ]);

        $this->addDefaultItems($character);

        return redirect()->route('dashboard')->with('success', 'Personnage créé avec succès !');
    }

    public function create()
    {
        return Inertia::render('Character/CreateCharacter');
    }

    public function delete(Request $request)
    {
        $character = Character::findOrFail($request->character_id);
        $character->delete();

        return to_route('dashboard')->with('message', 'Votre personnage à trépassé.');
    }

    private function addDefaultItems(Character $character)
    {
        $rags = Item::firstOrCreate(
            ['name' => 'Haillons'],
            [
                'description' => 'Des vêtements usés et rapiécés.',
                'item_type' => 'armor',
                'armor_bonus' => 0,
                'damage_bonus' => 0,
                'value' => 1,
                'rarity' => 'common',
            ]
        );

        $knife = Item::firstOrCreate(
            ['name' => 'Couteau en fer'],
            [
                'description' => 'Un simple couteau en fer, à peine aiguisé.',
                'item_type' => 'weapon',
                'armor_bonus' => 0,
                'damage_bonus' => 1,
                'value' => 5,
                'rarity' => 'common',
            ]
        );

        $character->inventory()->create(['item_id' => $rags->id, 'equipped' => true]);
        $character->inventory()->create(['item_id' => $knife->id, 'equipped' => true]);
    }
}
