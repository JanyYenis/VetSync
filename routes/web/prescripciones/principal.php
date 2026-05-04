<?php

use App\Http\Controllers\PrescripcionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PrescripcionController::class, 'index'])
    ->name('index');
Route::get('/listado', [PrescripcionController::class, 'listado'])
    ->name('listado');
Route::get('/crear', [PrescripcionController::class, 'create'])
    ->name('create');
Route::post('/guardar', [PrescripcionController::class, 'store'])
    ->name('store');
Route::get('{cliente}/editar', [PrescripcionController::class, 'edit'])
    ->name('edit');
Route::put('{cliente}/actualizar', [PrescripcionController::class, 'update'])
    ->name('update');
Route::delete('{cliente}/eliminar', [PrescripcionController::class, 'delete'])
    ->name('delete');
Route::post('buscar', [PrescripcionController::class, 'buscar'])
    ->name('buscar');
Route::get('dar-presentacion', [PrescripcionController::class, 'darPresentacion'])
    ->name('dar-presentacion');
Route::get('dar-frecuencia', [PrescripcionController::class, 'darFrecuencia'])
    ->name('dar-frecuencia');
Route::get('dar-duracion', [PrescripcionController::class, 'darDuracion'])
    ->name('dar-duracion');
