<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CharacterController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $characters = $user->characters;

    return Inertia::render('Dashboard', [
        'characters' => $characters,
        'noCharacters' => $characters->isEmpty(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/characters/create', function () {
    return Inertia::render('CreateCharacter');
})->middleware(['auth', 'verified'])->name('characters.create');

Route::post('/characters', [CharacterController::class, 'store'])->name('characters.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
