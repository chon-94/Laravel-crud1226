<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// Página de inicio -> Lista de productos
Route::get('/', [ProductoController::class, 'index'])->name('inicio');

// Rutas del CRUD de productos (generadas automáticamente)
Route::resource('productos', ProductoController::class);