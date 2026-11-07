<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    
    {{-- Cargamos los estilos de Tailwind CSS compilados por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- ========================================== --}}
    {{-- BARRA DE NAVEGACIÓN SUPERIOR --}}
    {{-- ========================================== --}}
    <nav class="bg-white shadow-md p-4 mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Mi Tienda</h1>
            
            {{-- Solo mostramos estos botones si el admin está logueado --}}
            @if(session('es_admin'))
                <div class="flex gap-3">
                    {{-- Botón para ir al formulario de crear --}}
                    <a href="{{ route('productos.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition text-sm font-bold">
                        + Agregar Producto
                    </a>
                    
                    {{-- Botón para cerrar sesión (limpiar la variable de sesión) --}}
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition text-sm font-bold">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </nav>

    {{-- ========================================== --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ========================================== --}}
    <div class="container mx-auto px-4">
        
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Nuestros Productos</h2>

        {{-- Mostrar mensajes de éxito (flash messages) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid responsivo: 1 columna en móvil, 3 en pantallas medianas/grandes --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            
            {{-- Recorremos todos los productos que vienen del controlador --}}
            @forelse($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col">
                    
                    {{-- Sección de la Imagen --}}
                    <div class="h-48 bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-400 text-sm">Sin imagen</span>
                        @endif
                    </div>
                    
                    {{-- Sección de la Información --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $producto->nombre }}</h3>
                        
                        {{-- Limitamos la descripción a 60 caracteres para que las tarjetas se vean parejas --}}
                        <p class="text-gray-600 mt-2 text-sm flex-grow">{{ Str::limit($producto->descripcion, 60) }}</p>
                        
                        <p class="text-2xl font-bold text-blue-600 mt-4">S/ {{ number_format($producto->precio, 2) }}</p>
                        
                        {{-- BOTONES PÚBLICOS (Siempre visibles) --}}
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('productos.show', $producto) }}" 
                               class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600 transition text-sm font-medium">
                               Detalle
                            </a>
                            
                            {{-- Link de WhatsApp: Abre el chat con un mensaje pre-llenado --}}
                            <a href="https://wa.me/{{ $producto->telefono }}?text=Hola, me interesa el producto {{ $producto->nombre }}" 
                               target="_blank"
                               class="flex-1 bg-green-500 text-white text-center py-2 rounded hover:bg-green-600 transition text-sm font-medium">
                               Contactar
                            </a>
                        </div>

                        {{-- BOTONES DE ADMIN (Solo visibles si session('es_admin') es true) --}}
                        @if(session('es_admin'))
                            <div class="mt-3 flex gap-2 border-t pt-3">
                                <a href="{{ route('productos.edit', $producto) }}" 
                                   class="flex-1 bg-yellow-500 text-white text-center py-2 rounded hover:bg-yellow-600 transition text-sm font-medium">
                                   Editar
                                </a>
                                
                                {{-- Formulario para eliminar (usa el método DELETE de Laravel) --}}
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este producto?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition text-sm font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            @empty
                {{-- Si no hay productos en la base de datos --}}
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500 text-lg">Aún no hay productos publicados.</p>
                </div>
            @endforelse

        </div>
    </div>

</body>
</html>