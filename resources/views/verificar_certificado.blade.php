<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Certificado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-2xl w-full">
        <div class="bg-green-600 p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-3xl font-bold text-white">Certificado Válido</h1>
            <p class="text-green-100 mt-2">El certificado ha sido verificado correctamente en nuestros registros.</p>
        </div>
        
        <div class="p-8">
            <div class="mb-6 text-center">
                <p class="text-gray-500 text-sm uppercase tracking-wide mb-1">Otorgado a</p>
                <h2 class="text-2xl font-bold text-gray-800 uppercase">{{ $user->paternal_surname }} {{ $user->maternal_surname }} {{ $user->name }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase mb-1">Evento</p>
                    <p class="font-semibold text-gray-800">{{ $evento->name }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase mb-1">Rol</p>
                    <p class="font-semibold text-gray-800">{{ $rol }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase mb-1">Fecha</p>
                    <p class="font-semibold text-gray-800">{{ $fechaTexto }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase mb-1">Código de Verificación</p>
                    <p class="font-mono text-gray-600 text-sm break-all">{{ $certificado->id ?? $user->id }}</p>
                </div>
            </div>

            <div class="text-center text-sm text-gray-400">
                Emitido por Facultad de Ingeniería de Sistemas - UNCP
            </div>
        </div>
    </div>
</body>
</html>
