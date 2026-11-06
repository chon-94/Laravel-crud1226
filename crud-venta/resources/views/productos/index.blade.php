<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-10">

    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Nuestros Productos</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @foreach($productos as $producto)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Imagen (usamos un placeholder si no hay) -->
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400">Sin imagen</span>
                    @endif
                </div>
                
                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $producto->nombre }}</h2>
                    <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($producto->descripcion, 50) }}</p>
                    <p class="text-2xl font-bold text-blue-600 mt-4">S/ {{ $producto->precio }}</p>
                    
                    <div class="mt-4 flex gap-2">
                        <!-- Botón Detalle -->
                        <a href="{{ route('productos.show', $producto) }}" 
                           class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600 transition">
                           Detalle
                        </a>
                        
                        <!-- Botón Contactar (WhatsApp) -->
                        <a href="https://wa.me/{{ $producto->telefono }}?text=Hola, me interesa el producto {{ $producto->nombre }}" 
                           target="_blank"
                           class="flex-1 bg-green-500 text-white text-center py-2 rounded hover:bg-green-600 transition">
                           Contactar
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>