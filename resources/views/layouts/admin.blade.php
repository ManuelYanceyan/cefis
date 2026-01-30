<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-full h-lvh flex flex-col items-stretch">
    <header class="bg-amber-400 shadow-md py-4">
        <div class="container mx-auto text-center relative">
            <h1 class="text-3xl font-bold uppercase text-gray-900">
                Administracion de certificados
            </h1>
            <p class="text-lg font-bold text-gray-800 mt-1">
                Fis-UNCP
            </p>
            
            @auth
                <div class="absolute top-0 right-0 mt-2 mr-4 ">
                    @yield('conteido')
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded shadow" type="submit">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <main class="container mx-auto py-6 px-4">
        @yield('contenido')
    </main>
    
</body>
</html>