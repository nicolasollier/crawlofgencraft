<?php

namespace App\Http\Controllers;

use App\Models\Dungeon;
use Illuminate\Http\Request;
use App\Models\Character;
use Inertia\Inertia;
use App\Models\Room;

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
            'room_count' => 0,
        ]);


        $startRoom = Room::generate('start', $dungeon);
        $dungeon->rooms()->save($startRoom);

        $dungeon = Dungeon::with('rooms')->find($dungeon->id);

        return to_route('dashboard')->with('dungeon', $dungeon);
    }

    public function progress(Request $request)
    {
        $dungeon = Dungeon::with('rooms')->findOrFail($request->dungeon_id);
        $dungeon->room_count++;

        $room_types = ['encounter', 'trapped', 'treasure', 'enigma', 'empty'];
        $random_room_type = $room_types[array_rand($room_types)];

        if ($dungeon->room_count >= $dungeon->rooms->count()) {
            $newRoom = Room::generate($random_room_type, $dungeon);
            $dungeon->rooms()->save($newRoom);
        }

        $dungeon->save();
        $dungeon = Dungeon::with('rooms')->find($request->dungeon_id);

        return Inertia::render('Dungeon/Progress', [
            'dungeon' => $dungeon
        ]);
    }
}
