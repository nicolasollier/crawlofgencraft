<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Dungeon;
use App\Models\Room;
use App\Services\DungeonProgressionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DungeonController extends Controller
{
    public function create(Request $request)
    {
        $character = Character::find($request->character_id);

        if (! $character) {
            return Inertia::render('Dashboard', [
                'error' => 'Vous n\'avez pas de personnage',
            ]);
        }

        $dungeon = Dungeon::create([
            'character_id' => $character->id,
            'name' => 'Donjon de '.$character->name,
            'size' => $request->size,
            'room_count' => 0,
        ]);

        $startRoom = Room::generate('start', $dungeon, null, true);
        $dungeon->rooms()->save($startRoom);

        $dungeon = Dungeon::with('rooms')->find($dungeon->id);

        return to_route('dashboard')->with('dungeon', $dungeon);
    }

    public function progress(Request $request)
    {
        $dungeon = Dungeon::with('rooms')->findOrFail($request->dungeon_id);

        $progressionService = new DungeonProgressionService;
        $progressionService->progressDungeon($dungeon, $request->action);

        $dungeon = Dungeon::with('rooms')->find($request->dungeon_id);

        return to_route('dashboard')->with('dungeon', $dungeon);
    }

    public function destroy(Request $request)
    {
        $dungeon = Dungeon::findOrFail($request->dungeon_id);
        $dungeon->delete();

        return to_route('dashboard')->with('message', 'Vous êtes sorti du donjon.');
    }
}
