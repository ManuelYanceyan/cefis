@extends('layouts.admin')

@section('contenido')
    <!-- Custom Header specific for this view as per user request -->
    <div class="bg-yellow-400 p-4 flex justify-between items-center mb-0 -mx-6 -mt-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800 uppercase tracking-wide">ADMINISTRACION DE CERTIFICADOS</h1>
            <p class="text-sm text-gray-700 font-semibold">FIS-UNCP</p>
        </div>
        <a href="{{ route('evento', $evento->id) }}" class="text-red-600 font-bold hover:text-red-800 text-lg">
            Salir
        </a>
    </div>

    <div class="bg-blue-200 p-3 text-center mb-6 -mx-6 text-gray-700 font-bold text-xl uppercase tracking-wider relative shadow-sm">
        CERTIFICADOS DEL EVENTO {{ $evento->name }}
    </div>

    <!-- Organizadores -->
    <div class="mb-8 bg-white/50">
        <h2 class="text-lg font-bold text-gray-700 mb-2 px-4 uppercase">Organizadores</h2>
        
        <div class="flex items-center mb-4 px-4">
            <a href="{{ route('generate-certificados-organizadores', $evento->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow text-sm">
                Generar certificados
            </a>
        </div>

        <ul class="flex flex-col items-stretch bg-transparent">
            @forelse ($organizadores as $organizador)
                <li class="px-4 py-2 flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <p class="text-lg uppercase text-slate-600 font-medium">
                        {{ $organizador->paternal_surname }} {{ $organizador->maternal_surname }} {{ $organizador->name }}
                    </p>
                    @if($organizador->pivot->certificado_creado)
                        <div class="flex items-center gap-2">
                            <span class="text-lg text-green-500 font-bold">Creado</span>
                            <a href="{{ route('certificado.download', ['evento_id' => $evento->id, 'certificado_id' => $organizador->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Ver
                            </a>
                        </div>
                    @else
                         <!-- No mostramos nada si no está creado o mostramos algo muy sutil? En la imagen, todos dicen Creado o No creado? -->
                         <!-- En la imagen 2 se ve "No creado" en naranja a la derecha -->
                        <span class="text-lg text-amber-500 font-bold">No creado</span>
                    @endif
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">No hay organizadores registrados.</li>
            @endforelse
        </ul>
    </div>

    <!-- Ponentes -->
    <div class="mb-8 bg-white/50">
        <h2 class="text-lg font-bold text-gray-700 mb-2 px-4 uppercase">Ponentes</h2>
        
        <div class="flex items-center mb-4 px-4">
             <a href="{{ route('generate-certificados-ponentes', $evento->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow text-sm">
                Generar certificados
            </a>
        </div>
        
        <ul class="flex flex-col items-stretch bg-transparent">
            @forelse ($ponentes as $ponente)
                <li class="px-4 py-2 flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <div class="grow">
                        <p class="text-lg uppercase text-slate-600 font-medium">
                            {{ $ponente->paternal_surname }} {{ $ponente->maternal_surname }} {{ $ponente->name }}
                        </p>
                        @if($ponente->pivot->ponencia)
                            <p class="text-xs text-gray-400 uppercase">
                                {{ $ponente->pivot->ponencia }}
                            </p>
                        @endif
                    </div>
                    
                    @if($ponente->pivot->certificado_creado)
                        <div class="flex items-center gap-2">
                            <span class="text-lg text-green-500 font-bold">Creado</span>
                            <a href="{{ route('certificado.download', ['evento_id' => $evento->id, 'certificado_id' => $ponente->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Ver
                            </a>
                        </div>
                    @else
                        <span class="text-lg text-amber-500 font-bold">No creado</span>
                    @endif
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">No hay ponentes registrados.</li>
            @endforelse
        </ul>
    </div>

    <!-- Asistentes -->
    <div class="mb-8 bg-white/50">
        <h2 class="text-lg font-bold text-gray-700 mb-2 px-4 uppercase">Asistentes</h2>
        
        <div class="flex items-center mb-4 px-4">
             <a href="{{ route('generate-certificados-asistentes', $evento->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow text-sm">
                Generar certificados
            </a>
        </div>
        
        <ul class="flex flex-col items-stretch bg-transparent">
            @forelse ($asistentes as $asistente)
                <li class="px-4 py-2 flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <p class="text-lg uppercase text-slate-600 font-medium">
                        {{ $asistente->paternal_surname }} {{ $asistente->maternal_surname }} {{ $asistente->name }}
                    </p>
                    @if($asistente->pivot->certificado_creado)
                        <div class="flex items-center gap-2">
                            <span class="text-lg text-green-500 font-bold">Creado</span>
                            <a href="{{ route('certificado.download', ['evento_id' => $evento->id, 'certificado_id' => $asistente->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Ver
                            </a>
                        </div>
                    @else
                        <span class="text-lg text-amber-500 font-bold">No creado</span>
                    @endif
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">No hay asistentes registrados.</li>
            @endforelse
        </ul>
    </div>

    <!-- Preregistrados -->
    <div class="mb-8 bg-white/50">
        <h2 class="text-lg font-bold text-gray-700 mb-2 px-4 uppercase">Preregistrados</h2>
        
        <div class="flex items-center mb-4 px-4">
             <a href="{{ route('generate-certificados-preregistrados', $evento->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow text-sm">
                Generar certificados
            </a>
        </div>
        
        <ul class="flex flex-col items-stretch bg-transparent">
            @forelse ($preregistrados as $pre)
                <li class="px-4 py-2 flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <p class="text-lg uppercase text-slate-600 font-medium">
                        {{ $pre->paternal_surname }} {{ $pre->maternal_surname }} {{ $pre->name }}
                    </p>
                    @if($pre->pivot->certificado_creado)
                        <div class="flex items-center gap-2">
                            <span class="text-lg text-green-500 font-bold">Creado</span>
                            <a href="{{ route('certificado.download', ['evento_id' => $evento->id, 'certificado_id' => $pre->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded text-xs">
                                Ver
                            </a>
                        </div>
                    @else
                        <span class="text-lg text-amber-500 font-bold">No creado</span>
                    @endif
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">No hay preregistrados.</li>
            @endforelse
        </ul>
    </div>
@endsection
