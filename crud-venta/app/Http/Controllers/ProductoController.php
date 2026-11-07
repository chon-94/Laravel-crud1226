<?php
// ↑ Apertura de PHP. OBLIGATORIA. Sin esto, el archivo no se ejecuta.

namespace App\Http\Controllers;
// ↑ Namespace del controlador. Se mapea a app/Http/Controllers/ (PSR-4).
//   Laravel los agrupa aquí para separar la capa HTTP (peticiones/respuestas)
//   de la lógica de dominio (Modelos) y de las vistas (Blade).

use App\Models\Producto;
// ↑ Importa el modelo Producto.
//   Gracias al `use`, dentro de la clase se puede escribir `Producto::all()`
//   en vez de `\App\Models\Producto::all()`.

use Illuminate\Http\Request;
// ↑ Importa la clase Request de Laravel.
//   ⚠️ OJO: aquí NO se usa en ningún método → es un "use" sin uso.
//   El método show() tipa Producto, no Request.
//   Si más adelante implementas store(Request $request) o update(Request $request),
//   entonces sí lo necesitarás. Por ahora es ruido.

class ProductoController extends Controller
// ↑ Declaración del controlador.
//   - "extends Controller" apunta a App\Http\Controllers\Controller
//     (la clase abstracta base que me mostraste antes).
//   - Ese Controller base es quien, en Laravel 11, permite centralizar
//     middleware, traits y helpers comunes a todos los controladores.
//   - Sin ese `extends`, el controlador sigue funcionando pero pierdes
//     la posibilidad de compartir comportamiento y, en versiones
//     anteriores a Laravel 11, los traits AuthorizesRequests y
//     ValidatesRequests que traía por defecto.
{

    // ═══════════════════════════════════════════════════════════════
    // index() → listar todos los productos
    // Ruta: GET /productos  → nombre "productos.index"
    // (también accesible por GET / con name="inicio" según tus rutas)
    // ═══════════════════════════════════════════════════════════════
    public function index()
    // ↑ Método público (Laravel lo invoca desde la ruta).
    //   Sin parámetros: no recibe datos de la URL.
    //   Retorna la vista con la lista de productos.
    {
        $productos = Producto::all();
        // ↑ Producto::all() ejecuta SELECT * FROM productos
        //   y devuelve una Collection (Illuminate\Support\Collection)
        //   de modelos Producto. Cada elemento es una fila.
        //
        //   ⚠️ Consideración de rendimiento:
        //   all() trae TODOS los registros y TODAS las columnas.
        //   Con 10.000 productos → 10.000 objetos en memoria.
        //   Mejoras posibles:
        //     Producto::paginate(12);          // paginación (recomendado)
        //     Producto::select('id','nombre','precio','imagen_url')->get();
        //     Producto::orderBy('nombre')->get();
        //
        //   El comentario original dice "podemos regularlarlo" →
        //   esa es exactamente la idea: paginar u ordenar.

        return view('productos.index', compact('productos'));
        // ↑ Retorna una respuesta HTTP con la vista Blade renderizada.
        //   - 'productos.index'   → busca resources/views/productos/index.blade.php
        //   - compact('productos') → equivale a ['productos' => $productos]
        //     Inyecta la variable $productos a la vista.
        //
        //   Convención Laravel: separar por puntos = subcarpetas con puntos.
        //     productos.index → resources/views/productos/index.blade.php
        //     productos.show  → resources/views/productos/show.blade.php
    }

    // ═══════════════════════════════════════════════════════════════
    // show() → mostrar detalle de UN producto
    // Ruta: GET /productos/{producto}  → nombre "productos.show"
    // ═══════════════════════════════════════════════════════════════
    public function show(Producto $producto)
    // ↑ Route Model Binding implícito.
    //   Laravel ve el tipo Producto y el nombre de la variable $producto,
    //   lo empareja con el parámetro {producto} de la ruta, y:
    //     1. Toma el valor de la URL (ej: /productos/5 → "5").
    //     2. Busca en la BD: SELECT * FROM productos WHERE id = 5 LIMIT 1.
    //     3. Si lo encuentra → lo inyecta como $producto.
    //     4. Si NO lo encuentra → aborta con 404 automáticamente.
    //
    //   Requisitos para que funcione:
    //     • La ruta debe declarar {producto} (singular, igual al nombre
    //       del parámetro del método).
    //     • El modelo Producto debe existir.
    //     • La clave primaria del modelo es `id` (por defecto).
    //
    //   Si la ruta fuera {productos} (plural) → NO habría binding,
    //   y $producto sería un string "5" (fallaría el type hint → 500).
    {
        return view('productos.show', compact('producto'));
        // ↑ Renderiza resources/views/productos/show.blade.php
        //   pasando la variable $producto ya instanciada (un objeto).
    }
}
