<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DungeonController;
use App\Http\Controllers\MerchantController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

Route::get('/', function (): Response {
    return Inertia::render(component: 'Welcome', props: [
        'canLogin' => Route::has(name: 'login'),
        'canRegister' => Route::has(name: 'register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/merchant', [MerchantController::class, 'index'])->name('merchant');

    // Characters
    Route::get('/characters/create', [CharacterController::class, 'create'])->name('characters.create');
    Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');
    Route::delete('/characters/{character}', [CharacterController::class, 'delete'])->name('character.delete');

    // Dungeons
    Route::post('/dungeon', [DungeonController::class, 'create'])->name('dungeon.create');
    Route::post('/dungeon/progress', [DungeonController::class, 'progress'])->name('dungeon.progress');
    Route::delete('/dungeon/{dungeon}', [DungeonController::class, 'destroy'])->name('dungeon.destroy');
});

require __DIR__.'/auth.php';
