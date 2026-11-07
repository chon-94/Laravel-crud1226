{{-- resources/views/productos/index.blade.php --}}

{{-- Declaración del tipo de documento: HTML5 --}}
<!DOCTYPE html>

{{-- Etiqueta raíz del documento. lang="es" indica que el contenido está en español
     (útil para accesibilidad, lectores de pantalla y SEO) --}}
<html lang="es">

{{-- Cabecera del documento: metadatos, título, recursos --}}
<head>
    {{-- Codificación de caracteres. UTF-8 soporta tildes, ñ, emojis, etc.
         IMPORTANTE: debe ir siempre en los primeros 1024 bytes del documento --}}
    <meta charset="UTF-8">

    {{-- Título que aparece en la pestaña del navegador --}}
    <title>Lista de Productos</title>

    {{-- Directiva Blade @vite: inyecta las etiquetas <link> y <script> generadas por Vite.
         - resources/css/app.css  → hoja de estilos (aquí vive Tailwind CSS)
         - resources/js/app.js    → JavaScript de la app
         En desarrollo apunta al servidor de Vite (HMR); en producción a los archivos compilados
         con hash en /public/build. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Cuerpo visible de la página.
     Clases Tailwind:
       bg-gray-100 → fondo gris claro
       p-10        → padding de 2.5rem en todos los lados --}}
<body class="bg-gray-100 p-10">

    {{-- Título principal de la página.
         text-3xl       → tamaño de fuente grande (1.875rem)
         font-bold      → negrita
         text-center    → centrado
         mb-8           → margen inferior (2rem)
         text-gray-800  → color gris muy oscuro --}}
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Nuestros Productos</h1>

    {{-- Contenedor en formato grid (cuadrícula).
         grid                → activa display:grid
         grid-cols-1         → 1 columna por defecto (móvil)
         md:grid-cols-3      → a partir de breakpoint "md" (≥768px), 3 columnas
         gap-6               → separación de 1.5rem entre tarjetas
         max-w-6xl           → ancho máximo (72rem)
         mx-auto             → centra horizontalmente el grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">

        {{-- Bucle Blade: itera sobre la colección $productos que envió el controlador
             (ProductoController@index → Producto::all()).
             Cada iteración asigna un producto a $producto. --}}
        @foreach($productos as $producto)

            {{-- Tarjeta de producto.
                 bg-white              → fondo blanco
                 rounded-lg            → esquinas redondeadas
                 shadow-md             → sombra media
                 overflow-hidden       → recorta lo que sobresalga (ej. imagen)
                 hover:shadow-xl       → sombra más grande al pasar el mouse
                 transition-shadow     → anima solo la sombra
                 duration-300          → duración de la animación: 300ms --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">

                {{-- Contenedor de la imagen.
                     h-48            → altura fija (12rem)
                     bg-gray-200     → fondo gris si no hay imagen
                     flex + items-center + justify-center → centra el contenido
                     (útil para el texto "Sin imagen") --}}
                <div class="h-48 bg-gray-200 flex items-center justify-center">

                    {{-- Condicional Blade: si el producto tiene imagen_url definida y no vacía... --}}
                    @if($producto->imagen_url)

                        {{-- Etiqueta <img>:
                             - src: URL de la imagen del producto
                             - alt: texto alternativo (accesibilidad y SEO)
                             - w-full h-full     → ocupa todo el contenedor
                             - object-cover      → recorta la imagen para cubrir sin deformar
                             NOTA: usa {{ }} que ESCAPA el contenido (protección XSS).
                             Si imagen_url ya es una URL completa (http/https) está bien.
                             Si fuera solo un nombre de archivo, usarías asset() o Storage::url(). --}}
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">

                    {{-- Si no hay imagen, mostramos un texto de relleno --}}
                    @else
                        <span class="text-gray-400">Sin imagen</span>
                    @endif
                </div>

                {{-- Contenedor del contenido textual.
                     p-4 → padding de 1rem en todos los lados --}}
                <div class="p-4">

                    {{-- Nombre del producto.
                         text-xl        → tamaño grande
                         font-semibold  → semi-negrita
                         text-gray-800  → gris oscuro
                         {{ }} escapa el valor → seguro ante XSS --}}
                    <h2 class="text-xl font-semibold text-gray-800">{{ $producto->nombre }}</h2>

                    {{-- Descripción del producto.
                         text-gray-600 → gris medio
                         mt-2          → margen superior
                         text-sm       → texto pequeño
                         Str::limit($producto->descripcion, 50):
                             helper de Laravel que TRUNCA el texto a 50 caracteres
                             y añade "..." al final. Evita que descripciones largas
                             rompan el diseño de la tarjeta. --}}
                    <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($producto->descripcion, 50) }}</p>

                    {{-- Precio del producto.
                         text-2xl       → muy grande
                         font-bold      → negrita
                         text-blue-600  → azul
                         mt-4           → margen superior
                         "S/ " es el símbolo de sol peruano (puedes cambiarlo según el país) --}}
                    <p class="text-2xl font-bold text-blue-600 mt-4">S/ {{ $producto->precio }}</p>

                    {{-- Fila de botones.
                         mt-4     → margen superior
                         flex     → layout flexbox horizontal
                         gap-2    → separación entre botones --}}
                    <div class="mt-4 flex gap-2">

                        {{-- Botón "Detalle": enlace a la ruta nombrada productos.show.
                             route('productos.show', $producto) genera la URL pasando el modelo.
                             Laravel usará el ID (o la clave definida en getRouteKeyName) del producto.
                             Requiere que exista en routes/web.php:
                                 Route::get('/productos/{producto}', [ProductoController::class, 'show'])
                                     ->name('productos.show');
                             Clases Tailwind:
                                 flex-1                       → ocupa la mitad del ancho disponible
                                 bg-blue-500 / hover:bg-blue-600 → fondo azul y hover más oscuro
                                 text-white                   → texto blanco
                                 text-center                  → texto centrado
                                 py-2                         → padding vertical
                                 rounded                      → esquinas redondeadas
                                 transition                   → animación suave --}}
                        <a href="{{ route('productos.show', $producto) }}" 
                           class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600 transition">
                           Detalle
                        </a>

                        {{-- Botón "Contactar" vía WhatsApp.
                             Construye un enlace wa.me con:
                               - Número del producto: $producto->telefono (formato internacional, sin + ni espacios)
                               - Texto pre-rellenado con el nombre del producto (interpolación en Blade {{ }})
                             target="_blank" → abre en nueva pestaña
                             NOTA: wa.me requiere el número SIN el signo +. Ej: 51987654321.
                             Clases Tailwind análogas al botón anterior pero en verde. --}}
                        <a href="https://wa.me/{{ $producto->telefono }}?text=Hola, me interesa el producto {{ $producto->nombre }}" 
                           target="_blank"
                           class="flex-1 bg-green-500 text-white text-center py-2 rounded hover:bg-green-600 transition">
                           Contactar
                        </a>
                    </div>
                </div>
            </div>

        {{-- Fin del bucle @foreach --}}
        @endforeach
    </div>

</body>
</html>