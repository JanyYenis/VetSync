<?php

use App\Http\Controllers\HistorialClinicoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HistorialClinicoController::class, 'index'])
    ->name('index');
Route::get('/listado', [HistorialClinicoController::class, 'listado'])
    ->name('listado');
Route::post('/guardar', [HistorialClinicoController::class, 'store'])
    ->name('store');
Route::get('{historial}/editar', [HistorialClinicoController::class, 'edit'])
    ->name('edit');
Route::put('{historial}/actualizar', [HistorialClinicoController::class, 'update'])
    ->name('update');
Route::delete('{historial}/eliminar', [HistorialClinicoController::class, 'delete'])
    ->name('delete');
Route::get('buscar', [HistorialClinicoController::class, 'buscar'])
    ->name('buscar');
Route::get('{mascota}/cargar-mascota', [HistorialClinicoController::class, 'cargarDatos'])
    ->name('cargar.mascota');
