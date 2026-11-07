<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle: {{ $producto->nombre }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full overflow-hidden">
        
        {{-- Imagen --}}
        <div class="h-64 bg-gray-200 flex items-center justify-center">
            @if($producto->imagen_url)
                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
            @else
                <span class="text-gray-400 text-xl">Sin imagen</span>
            @endif
        </div>

        {{-- Contenido --}}
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-800 text-center">{{ $producto->nombre }}</h1>
            <p class="text-gray-600 mt-4 leading-relaxed">{{ $producto->descripcion }}</p>
            
            <div class="mt-6 border-t pt-4">
                <p class="text-sm text-gray-500 text-center">Precio:</p>
                <p class="text-4xl font-bold text-blue-600 text-center">S/ {{ number_format($producto->precio, 2) }}</p>
            </div>

            <a href="https://wa.me/{{ $producto->telefono }}?text=Hola buenos días, quiero comprar {{ $producto->nombre }}" 
               target="_blank"
               class="block w-full bg-green-500 text-white text-center text-xl font-bold py-3 rounded mt-8 hover:bg-green-600 transition shadow-md">
                Comprar por WhatsApp
            </a>

            <a href="{{ route('inicio') }}" class="block text-center text-blue-500 mt-6 hover:underline font-medium">
                ← Volver a la lista
            </a>
        </div>
    </div>

</body>
</html>