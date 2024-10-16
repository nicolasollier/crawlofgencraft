<?php

namespace App\Http\Controllers;

use App\Models\Character;
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
            'name' => $validated['name'],
            'hp' => 100,
            'mana' => 100,
            'gold' => 0,
            'strength' => $validated['strength'],
            'agility' => $validated['agility'],
            'intelligence' => $validated['intelligence'],
        ]);

        return redirect()->route('dashboard')->with('success', 'Personnage créé avec succès !');
    }
}