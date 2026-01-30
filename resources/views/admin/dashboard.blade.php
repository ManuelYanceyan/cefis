@extends('layouts.admin')

@section('title', 'Panel de Control')

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Bienvenido, Administrador</h1>
        <a href="{{ route('configurar-certificado') }}" class="mr-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Subir Certificado Base
        </a>
        <a href="{{ route('eventos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors duration-300 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Agregar Evento
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($eventos->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach ($eventos as $evento)
                    <li>
                        <a href="{{ route('eventos.show', $evento->id) }}" class="block px-6 py-4 hover:bg-gray-50 transition-colors duration-200 flex items-center justify-between group">
                            <div>
                                <span class="text-lg font-medium text-gray-800 group-hover:text-blue-600 transition-colors">
                                    {{ $evento->name }}
                                </span>
                                @if($evento->certificado_base)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Certificado
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center text-gray-400">
                                <span class="text-sm mr-4">
                                    {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 group-hover:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center py-10 text-gray-500">
                <p class="text-lg">No hay eventos registrados aún.</p>
                <p class="text-sm mt-2">¡Crea tu primer evento usando el botón de arriba!</p>
            </div>
        @endif
    </div>
@endsection