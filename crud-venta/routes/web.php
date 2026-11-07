<?php

// ═══════════════════════════════════════════════════════════════════
// routes/web.php
// Definición de rutas web. 
// NOTA: Se eliminó Route::resource para proteger las acciones de 
// escritura (store, update, destroy) detrás del middleware 'admin'.
// ═══════════════════════════════════════════════════════════════════

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductoController;


// ───────────────────────────────────────────────────────────────────
// ZONA PÚBLICA (Cualquiera puede ver esto)
// ───────────────────────────────────────────────────────────────────

// Muestra la lista de productos (Home)
Route::get('/', [ProductoController::class, 'index'])->name('inicio');

// Muestra el detalle de un producto específico.
// El {producto} usa Route Model Binding implícito (inyecta el modelo).
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');


// ───────────────────────────────────────────────────────────────────
// AUTENTICACIÓN SIMPLE (Sin base de datos de usuarios)
// ───────────────────────────────────────────────────────────────────

// Muestra el formulario de login
Route::get('/admin-login', function () {
    return view('admin.login');
})->name('admin.login');

// Procesa el login. Verifica el hash de forma segura contra el .env
Route::post('/admin-login', function (Request $request) {
    if (Hash::check($request->password, env('ADMIN_SECRET_HASH'))) {
        $request->session()->regenerate(); // Previene Session Fixation
        session(['es_admin' => true]);     // Marca la sesión como admin
        return redirect()->route('productos.create');
    }
    
    return back()->with('error', 'Contraseña incorrecta, oe.');
})->middleware('throttle:5,1')->name('admin.login.post'); // Bloquea tras 5 intentos fallidos en 1 min

// Cierra la sesión (limpia la variable de sesión)
Route::post('/admin-logout', function () {
    session()->forget('es_admin');
    return redirect()->route('inicio');
})->name('admin.logout');


// ───────────────────────────────────────────────────────────────────
// ZONA PRIVADA (Solo accesible si session('es_admin') === true)
// ───────────────────────────────────────────────────────────────────

Route::middleware('admin')->group(function () {
    
    // Muestra el formulario vacío para crear
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    
    // Guarda el nuevo producto en la BD
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    
    // Muestra el formulario con los datos actuales para editar
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    
    // Aplica los cambios en la BD
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    
    // Elimina el producto de la BD
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});