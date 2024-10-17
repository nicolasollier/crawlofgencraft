<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DungeonController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

// Welcome page route
Route::get('/', function (): Response {
    return Inertia::render(component: 'Welcome', props: [
        'canLogin' => Route::has(name: 'login'),
        'canRegister' => Route::has(name: 'register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Authentication required routes
Route::middleware(['auth', 'verified'])->group(function (): void {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Characters
    Route::get('/characters/create', [CharacterController::class, 'create'])->name('characters.create');
    Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');

    // Dungeons
    Route::post('/dungeon', [DungeonController::class, 'create'])->name('dungeon.create');
});

// Include authentication routes
require __DIR__ . '/auth.php';
