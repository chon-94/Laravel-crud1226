<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle: {{ $producto->nombre }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-10 flex justify-center">

    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full overflow-hidden">
        <!-- Imagen Grande -->
        <div class="h-64 bg-gray-200 flex items-center justify-center">
             @if($producto->imagen_url)
                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
            @else
                <span class="text-gray-400 text-xl">Sin imagen</span>
            @endif
        </div>

        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ $producto->nombre }}</h1>
            <p class="text-gray-600 mt-4 leading-relaxed">{{ $producto->descripcion }}</p>
            
            <div class="mt-6 border-t pt-4">
                <p class="text-sm text-gray-500">Precio:</p>
                <p class="text-4xl font-bold text-blue-600">S/ {{ $producto->precio }}</p>
            </div>

            <!-- Botón Comprar (WhatsApp) -->
            <a href="https://wa.me/{{ $producto->telefono }}?text=Hola, quiero comprar el producto {{ $producto->nombre }}" 
               target="_blank"
               class="block w-full bg-green-500 text-white text-center text-xl font-bold py-3 rounded mt-8 hover:bg-green-600 transition shadow-md">
               🛒 Comprar por WhatsApp
            </a>

            <!-- Volver -->
            <a href="{{ route('productos.index') }}" class="block text-center text-blue-500 mt-4 hover:underline">
                ← Volver a la lista
            </a>
        </div>
    </div>

</body>
</html>