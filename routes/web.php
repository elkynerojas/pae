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

    // Rutas para gestión de huellas dactilares
    Route::post('/huella/guardar', [\App\Http\Controllers\HuellaController::class, 'guardarHuella'])->name('huella.guardar');
    Route::put('/huella/actualizar', [\App\Http\Controllers\HuellaController::class, 'actualizarHuella'])->name('huella.actualizar');
    Route::post('/huella/verificar', [\App\Http\Controllers\HuellaController::class, 'verificarHuella'])->name('huella.verificar');
    Route::get('/beneficiarios/{beneficiario}/huella', [\App\Http\Controllers\HuellaController::class, 'obtenerHuella'])->name('beneficiarios.huella');
    
    // Rutas para agregar beneficiarios a entregas con validación de huella
    Route::get('/entregas/{entrega}/agregar-beneficiario', [\App\Http\Controllers\EntregaBeneficiarioController::class, 'create'])->name('entregas.agregar-beneficiario');
    Route::post('/entregas/{entrega}/agregar-beneficiario', [\App\Http\Controllers\EntregaBeneficiarioController::class, 'store'])->name('entregas.agregar-beneficiario.store');
    Route::post('/entregas/validar-huella', [\App\Http\Controllers\EntregaBeneficiarioController::class, 'validarHuella'])->name('entregas.validar-huella');

    // Rutas para gestión de backups
    Route::resource('backups', \App\Http\Controllers\BackupController::class);
    Route::get('/backups/{backup}/download', [\App\Http\Controllers\BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/{backup}/restore', [\App\Http\Controllers\BackupController::class, 'restore'])->name('backups.restore');
    Route::post('/backups/limpiar-antiguos', [\App\Http\Controllers\BackupController::class, 'limpiarAntiguos'])->name('backups.limpiar-antiguos');
    Route::get('/backups/estadisticas', [\App\Http\Controllers\BackupController::class, 'estadisticas'])->name('backups.estadisticas');

});

require __DIR__.'/auth.php';
