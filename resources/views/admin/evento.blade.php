@extends('layouts.admin')

@section('contenido')
    
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">{{ $evento->name }}</h2>
        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-semibold flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al Panel
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('admin-certificados', ['evento_id' => $evento->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" />
                </svg>
                Certificados
            </a>
            <a href="{{ route('configurar-certificado') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Certificado Base
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Sección Organizadores -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-700">Organizadores</h3>
                <div class="flex space-x-2">
                    <a href="{{ route('export-organizadores', ['evento_id' => $evento->id]) }}" class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full hover:bg-green-200 transition-colors font-semibold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" />
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('add-organizador', ['evento_id' => $evento->id]) }}" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full hover:bg-blue-200 transition-colors font-semibold">
                        + Agregar
                    </a>
                </div>
            </div>
            
            @if($organizadores->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($organizadores as $organizador)
                        <li class="px-6 py-3 hover:bg-gray-50 flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold mr-3">
                                {{ substr($organizador->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">
                                {{ $organizador->paternal_surname }} {{ $organizador->maternal_surname }} {{ $organizador->name }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-6 text-center text-gray-500 text-sm">
                    No hay organizadores registrados.
                </div>
            @endif
        </div>

        <!-- Sección Ponentes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-700">Ponentes</h3>
                <a href="{{ route('add-ponente', ['evento_id' => $evento->id]) }}" class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full hover:bg-green-200 transition-colors font-semibold">
                    + Agregar
                </a>
            </div>
            
            @if($ponentes->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($ponentes as $ponente)
                        <li class="px-6 py-3 hover:bg-gray-50 flex items-start">
                            <div class="h-8 w-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold mr-3 mt-1 flex-shrink-0">
                                {{ substr($ponente->name, 0, 1) }}
                            </div>
                            <div>
                                <span class="block text-gray-800 font-medium">
                                    {{ $ponente->paternal_surname }} {{ $ponente->maternal_surname }} {{ $ponente->name }}
                                </span>
                                @if($ponente->pivot->ponencia)
                                    <span class="block text-sm text-gray-500 italic">
                                        Tema: "{{ $ponente->pivot->ponencia }}"
                                    </span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-6 text-center text-gray-500 text-sm">
                    No hay ponentes registrados.
                </div>
            @endif
        </div>

        <!-- Sección Asistentes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-700">Asistentes</h3>
                <a href="{{ route('add-asistente', ['evento_id' => $evento->id]) }}" class="text-sm bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full hover:bg-indigo-200 transition-colors font-semibold">
                    + Agregar
                </a>
            </div>
            
            @if($asistentes->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($asistentes as $a)
                        <li class="px-6 py-3 hover:bg-gray-50 flex items-center">
                            <div class="h-8 w-8 rounded-full bg-indigo-500 text-white flex items-center justify-center text-sm font-bold mr-3">
                                {{ substr($a->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">
                                {{ $a->paternal_surname }} {{ $a->maternal_surname }} {{ $a->name }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-6 text-center text-gray-500 text-sm">
                    No hay asistentes registrados.
                </div>
            @endif
        </div>

        <!-- Sección Preregistrados -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-700">Preregistrados</h3>
                <a href="{{ route('add-preregistrado', ['evento_id' => $evento->id]) }}" class="text-sm bg-purple-100 text-purple-700 px-3 py-1 rounded-full hover:bg-purple-200 transition-colors font-semibold">
                    + Agregar
                </a>
            </div>
            
            @if($preregistrados->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($preregistrados as $pre)
                        <li class="px-6 py-3 hover:bg-gray-50 flex items-center">
                            <div class="h-8 w-8 rounded-full bg-purple-500 text-white flex items-center justify-center text-sm font-bold mr-3">
                                {{ substr($pre->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">
                                {{ $pre->paternal_surname }} {{ $pre->maternal_surname }} {{ $pre->name }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-6 text-center text-gray-500 text-sm">
                    No hay preregistrados.
                </div>
            @endif
        </div>



    </div>

@endsection
