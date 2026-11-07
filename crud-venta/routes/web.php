<?php

// ═══════════════════════════════════════════════════════════════════
// routes/web.php
// Archivo de definición de rutas web de la aplicación.
// Laravel carga este archivo automáticamente gracias al RouteServiceProvider
// (o en Laravel 11, desde bootstrap/app.php → withRouting(web: ...)).
// Todas las rutas aquí definidas reciben el grupo de middleware "web":
//   - sesiones, cookies, CSRF, etc.
// ═══════════════════════════════════════════════════════════════════

// Importa la fachada Route, la clase principal para registrar rutas.
// "Facade" en Laravel = acceso estático a un servicio del contenedor.
use Illuminate\Support\Facades\Route;

// Importa el controlador que va a gestionar estas rutas.
// Gracias a esto podemos referirnos a él como ProductoController::class
// (más seguro que escribir el string 'App\Http\Controllers\ProductoController',
//  porque el IDE y PHP detectan errores de tipeo y permite "ir a la definición").
use App\Http\Controllers\ProductoController;


// ───────────────────────────────────────────────────────────────────
// RUTA DE INICIO
// ───────────────────────────────────────────────────────────────────

// Route::get(...) registra una ruta que responde a peticiones HTTP GET.
//   '/'  → URL raíz del sitio (ej: https://midominio.com/)
//   [ProductoController::class, 'index'] → controlador y método a ejecutar.
//       Formato "array callable": [Clase, 'metodo'].
//       Laravel instancia el controlador y llama a ->index().
//   ->name('inicio') → asigna un NOMBRE a la ruta.
//       Permite referenciarla luego con route('inicio') o redirect()->route('inicio'),
//       sin hardcodear la URL. Si cambias la URL, el nombre sigue funcionando.
Route::get('/', [ProductoController::class, 'index'])->name('inicio');


// ───────────────────────────────────────────────────────────────────
// RUTAS DEL CRUD (resource)
// ───────────────────────────────────────────────────────────────────

// Route::resource(...) registra de una sola vez las 7 rutas RESTful típicas de un CRUD:
//
//   Método HTTP | URL                    | Acción    | Nombre de ruta
//   ────────────┼────────────────────────┼───────────┼─────────────────────
//   GET         | /productos             | index     | productos.index
//   GET         | /productos/create      | create    | productos.create
//   POST        | /productos             | store     | productos.store
//   GET         | /productos/{producto}  | show      | productos.show
//   GET         | /productos/{producto}/edit | edit  | productos.edit
//   PUT/PATCH   | /productos/{producto}  | update    | productos.update
//   DELETE      | /productos/{producto}  | destroy   | productos.destroy
//
// Notas:
//  - El primer argumento 'productos' es el PREFIJO de URL y base del nombre de ruta.
//  - El segundo argumento es la clase del controlador.
//  - El parámetro dinámico {producto} coincide con el nombre singular de 'productos'.
//    Ese nombre es el que permite el ROUTE MODEL BINDING implícito:
//    al declarar show(Producto $producto) en el controlador, Laravel
//    inyecta automáticamente el modelo encontrado por su clave primaria.
//  - Si el modelo no se encuentra → 404 automático.
Route::resource('productos', ProductoController::class);