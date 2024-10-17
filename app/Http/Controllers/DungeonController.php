<?php

namespace App\Http\Controllers;

use App\Models\Dungeon;
use Illuminate\Http\Request;

class DungeonController extends Controller
{
    public function create(Request $request)
    {
        $character = $request->user()->characters()->first();
        $dungeon = Dungeon::create([
            'character_id' => $character->id,
        ]);
        return response()->json($dungeon);
    }
}
