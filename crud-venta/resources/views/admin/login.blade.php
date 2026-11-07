<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Admin</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-white text-2xl font-bold mb-6 text-center">Zona Restringida</h2>
        
        @if(session('error'))
            <div class="bg-red-500 text-white p-2 rounded mb-4 text-center text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <input type="password" name="password" placeholder="Contraseña maestra" 
                   class="w-full p-3 rounded bg-gray-700 text-white mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700 transition">
                Entrar
            </button>
        </form>
    </div>
</body>
</html>