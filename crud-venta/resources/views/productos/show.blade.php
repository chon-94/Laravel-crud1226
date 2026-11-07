{{-- resources/views/productos/show.blade.php --}}

{{-- Tipo de documento HTML5 --}}
<!DOCTYPE html>

{{-- Raíz del documento. lang="es" indica idioma español (accesibilidad + SEO) --}}
<html lang="es">

{{-- Cabecera: metadatos y recursos --}}
<head>
    {{-- Codificación UTF-8, obligatoria para tildes y ñ --}}
    <meta charset="UTF-8">

    {{-- Título dinámico de la pestaña.
         Interpola el nombre del producto → ej: "Detalle: Laptop HP"
         El {{ }} escapa el valor (protección XSS). --}}
    <title>Detalle: {{ $producto->nombre }}</title>

    {{-- @vite inyecta CSS (Tailwind) y JS compilados/gestionados por Vite.
         Requiere npm install + npm run dev (o npm run build). --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Cuerpo con centrado horizontal.
     bg-gray-100     → fondo gris claro
     p-10            → padding general (2.5rem)
     flex            → activa flexbox en el body
     justify-center  → centra el hijo horizontalmente
     (aquí solo hay un hijo: la tarjeta blanca)
     ⚠️ Curiosidad: no hay items-center, así que la tarjeta se alinea arriba,
     no centrada verticalmente. Con min-h-screen + items-center quedaría perfectamente centrada. --}}
<body class="bg-gray-100 p-10 flex justify-center"> 

    {{-- Tarjeta principal del producto.
         bg-white         → fondo blanco
         rounded-lg       → esquinas redondeadas
         shadow-lg        → sombra grande
         max-w-2xl        → ancho máximo (42rem ≈ 672px)
         w-full           → ocupa el 100% hasta el máximo
         overflow-hidden  → recorta imagen dentro de las esquinas redondeadas --}}
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full overflow-hidden">

        <!-- Imagen Grande -->
        {{-- Contenedor de la imagen.
             h-64 → altura fija (16rem ≈ 256px)
             bg-gray-200 → fondo gris (fallback si no hay imagen)
             flex + items-center + justify-center → centra el contenido (texto o imagen) --}}
        <div class="h-64 bg-gray-200 flex items-center justify-center">

             {{-- Si el producto tiene imagen_url válida, mostramos la imagen --}}
             @if($producto->imagen_url)

                {{-- <img>:
                     - src: URL de la imagen
                     - alt: texto alternativo (accesibilidad/SEO)
                     - w-full h-full   → ocupa todo el contenedor
                     - object-cover    → recorta la imagen para cubrir sin deformar --}}
                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">

            {{-- Fallback cuando no hay imagen --}}
            @else
                <span class="text-gray-400 text-xl">Sin imagen</span>
            @endif
        </div>

        {{-- Contenedor del contenido textual.
             p-8 → padding interior de 2rem --}}
        <div class="p-8">

            {{-- Nombre del producto.
                 text-3xl       → título grande
                 font-bold      → negrita
                 text-gray-800  → gris oscuro
                 Escapado automático por {{ }} → seguro ante XSS --}}
            <h1 class="text-3xl font-bold text-gray-800">{{ $producto->nombre }}</h1>

            {{-- Descripción completa (a diferencia del index, aquí NO se trunca).
                 text-gray-600      → gris medio
                 mt-4               → margen superior
                 leading-relaxed    → interlineado amplio, más legible en párrafos largos
                 Sin Str::limit → se muestra el texto entero --}}
            <p class="text-gray-600 mt-4 leading-relaxed">{{ $producto->descripcion }}</p>
            
            {{-- Bloque del precio, separado visualmente.
                 mt-6       → margen superior (1.5rem)
                 border-t   → línea divisoria superior
                 pt-4       → padding superior (1rem) --}}
            <div class="mt-6 border-t pt-4">

                {{-- Etiqueta pequeña "Precio:"
                     text-sm         → texto pequeño
                     text-gray-500   → gris medio-claro --}}
                <p class="text-sm text-gray-500">Precio:</p>

                {{-- Precio grande y destacado.
                     text-4xl       → muy grande
                     font-bold      → negrita
                     text-blue-600  → azul
                     "S/ " → símbolo del sol peruano (ajústalo según país) --}}
                <p class="text-4xl font-bold text-blue-600">S/ {{ $producto->precio }}</p>
            </div>

            <!-- Botón Comprar (WhatsApp) -->
            {{-- Enlace que abre WhatsApp con mensaje pre-rellenado.
                 Estructura de wa.me:
                   https://wa.me/<numero>?text=<mensaje_codificado>
                 - El número debe ir SIN "+", sin espacios ni guiones (ej: 51987654321)
                 - El texto se interpola con el nombre del producto
                 - target="_blank" → abre en pestaña nueva
                 Clases Tailwind:
                   block         → display:block (ocupa línea completa como botón grande)
                   w-full        → 100% de ancho
                   bg-green-500  → fondo verde (identidad WhatsApp)
                   hover:bg-green-600 → verde más oscuro al hover
                   text-white    → texto blanco
                   text-center   → centrado
                   text-xl       → texto grande
                   font-bold     → negrita
                   py-3          → padding vertical
                   rounded       → esquinas redondeadas
                   mt-8          → separación superior
                   transition    → animación suave
                   shadow-md     → sombra media
                   🛒 → emoji de carrito para reforzar la acción --}}
            <a href="https://wa.me/{{ $producto->telefono }}?text=Hola buenos dias, quiero comprar el producto {{ $producto->nombre }}" 
               target="_blank"
               class="block w-full bg-green-500 text-white text-center text-xl font-bold py-3 rounded mt-8 hover:bg-green-600 transition shadow-md">
               🛒 Comprar por WhatsApp
            </a>

            <!-- Volver -->
            {{-- Enlace de regreso al listado, usando la ruta NOMBRADA productos.index.
                 Requiere que en routes/web.php exista algo como:
                     Route::get('/productos', [ProductoController::class, 'index'])
                         ->name('productos.index');
                 Clases:
                   block          → ocupa línea completa (para centrar el texto)
                   text-center    → centrado
                   text-blue-500  → azul
                   mt-4           → separación superior
                   hover:underline → subrayado al pasar el mouse --}}
            <a href="{{ route('productos.index') }}" class="block text-center text-blue-500 mt-4 hover:underline">
                ← Volver a la lista
            </a>
        </div>
    </div>

</body>
</html>