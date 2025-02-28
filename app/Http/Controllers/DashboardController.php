<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user()->load(['characters.inventory.item', 'characters.dungeon']);
        $characters = $user->characters;

        $dungeons = $characters->pluck('dungeon')->filter()->values();

        return Inertia::render('Dashboard', [
            'characters' => $characters,
            'dungeons' => $dungeons,
        ]);
    }
}
