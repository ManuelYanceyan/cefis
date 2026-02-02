<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CEFIS</title>
	@vite('resources/css/app.css')
</head>
<body class="w-full h-lvh flex flex-col items-stretch">
	<header class="p-2 bg-amber-400 shadow-md shadow-gray-400" >
		<h1 class="text-2xl font-bold w-full text-center uppercase px-9">
			Administracion de certificados
		</h1>
		<p class="m-1 font-bold text-md text-center">
			FIS-UNCP
		</p>
		@auth
		<div class="w-full text-center">
			<a class="p-3 text-red-500 text-xl rounded-lg font-bold md:absolute md:top-0 md:right-0" href="{{route('logout')}}">Salir</a>
		</div>
		@endauth
	</header>
	<div class="w-full py-3 grow">
		@yield('contenido')
	</div>
</body>
</html>