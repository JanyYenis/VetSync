<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/precios', function () {
    return view('precios');
})->name('precios');
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');
Route::get('/perfil', [UsuarioController::class, 'perfil'])->name('perfil');
Route::prefix('paises')
    ->as("paises.")
    ->middleware(['web'])
    ->group(base_path('routes/web/paises/principal.php'));

Route::prefix('ciudades')
    ->as("ciudades.")
    ->middleware(['web'])
    ->group(base_path('routes/web/ciudades/principal.php'));

Route::prefix('usuarios')
    ->as("usuarios.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/usuarios/principal.php'));

Route::prefix('clientes')
    ->as("clientes.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/clientes/principal.php'));

Route::prefix('mascotas')
    ->as("mascotas.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/mascotas/principal.php'));

Route::prefix('historial-clinico')
    ->as("historiales.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/historiales/principal.php'));

Route::prefix('prescripciones')
    ->as("prescripciones.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/prescripciones/principal.php'));

Route::prefix('planes')
    ->as("planes.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/planes/principal.php'));

Route::prefix('clinicas')
    ->as("clinicas.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/clinicas/principal.php'));
