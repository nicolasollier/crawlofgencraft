<?php

namespace App\Http\Controllers;

use App\Models\Dungeon;
use Illuminate\Http\Request;
use App\Models\Character;
use Inertia\Inertia;

class DungeonController extends Controller
{
    public function create(Request $request)
    {

        $character = Character::find($request->character_id);

        if (!$character) {
            return Inertia::render('Dashboard', [
                'error' => 'Vous n\'avez pas de personnage'
            ]);
        }

        $dungeon = Dungeon::create([
            'character_id' => $character->id,
            'name' => "Donjon de " . $character->name,
            'size' => $request->size,
            'room_count' => 1,
        ]);

        return to_route('dashboard');
    }
}
