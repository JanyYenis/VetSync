<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EmpresaController::class, 'index'])->name('index');
