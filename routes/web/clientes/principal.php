<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClienteController::class, 'index'])
    ->name('index');
Route::get('/listado', [ClienteController::class, 'listado'])
    ->name('listado');
Route::post('/guardar', [ClienteController::class, 'store'])
    ->name('store');
Route::get('{cliente}/editar', [ClienteController::class, 'edit'])
    ->name('edit');
Route::put('{cliente}/actualizar', [ClienteController::class, 'update'])
    ->name('update');
Route::delete('{cliente}/eliminar', [ClienteController::class, 'delete'])
    ->name('delete');
Route::get('buscar', [ClienteController::class, 'buscar'])
    ->name('buscar');
