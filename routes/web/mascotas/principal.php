<?php

use App\Http\Controllers\MascotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MascotaController::class, 'index'])
    ->name('index');
Route::get('/listado', [MascotaController::class, 'listado'])
    ->name('listado');
Route::post('/guardar', [MascotaController::class, 'store'])
    ->name('store');
Route::get('{mascota}/editar', [MascotaController::class, 'edit'])
    ->name('edit');
Route::put('{mascota}/actualizar', [MascotaController::class, 'update'])
    ->name('update');
Route::delete('{mascota}/eliminar', [MascotaController::class, 'delete'])
    ->name('delete');
Route::get('buscar', [MascotaController::class, 'buscar'])
    ->name('buscar');
