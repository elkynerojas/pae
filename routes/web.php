<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para gestión de usuarios
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Rutas para operaciones de huella digital
    Route::prefix('api')->group(function () {
        Route::get('/obtener-todas-plantillas', [\App\Http\Controllers\HuellaDigitalController::class, 'obtenerTodasPlantillas'])->name('api.obtener-todas-plantillas');
    });
});

require __DIR__.'/auth.php';
