<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user()->load(relations: 'characters.inventory.item');
        $characters = $user->characters;

        return Inertia::render(component: 'Dashboard', props: [
            'characters' => $characters,
        ]);
    }
}
