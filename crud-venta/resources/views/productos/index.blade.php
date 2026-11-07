<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen p-4">

    <div class="container mx-auto max-w-6xl">
        <h1 class="text-3xl font-bold text-center mb-8 text-gray-800 mt-4">Nuestros Productos</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                    
                    {{-- Imagen --}}
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400">Sin imagen</span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $producto->nombre }}</h2>
                        <p class="text-gray-600 mt-2 text-sm flex-grow">{{ Str::limit($producto->descripcion, 60) }}</p>
                        <p class="text-2xl font-bold text-blue-600 mt-4">S/ {{ number_format($producto->precio, 2) }}</p>
                        
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('productos.show', $producto) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600 transition text-sm">
                               Detalle
                            </a>
                            <a href="https://wa.me/{{ $producto->telefono }}?text=Me interesa {{ $producto->nombre }}" 
                               target="_blank"
                               class="flex-1 bg-green-500 text-white text-center py-2 rounded hover:bg-green-600 transition text-sm">
                               Contactar
                            </a>
                        </div>

                        @if(session('es_admin'))
                            <div class="mt-3 flex gap-2 border-t pt-3">
                                <a href="{{ route('productos.edit', $producto) }}" 
                                   class="flex-1 bg-yellow-500 text-white text-center py-2 rounded hover:bg-yellow-600 text-sm">
                                   Editar
                                </a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Borrar?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">No hay productos.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>