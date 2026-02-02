@extends('layouts.admin')

@section('contenido')
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

    <div class="mb-8 bg-white/50">
        <h2 class="text-lg font-bold text-gray-700 mb-2 px-4 uppercase">Organizadores</h2>
        
        <div class="flex items-center mb-4 px-4">
    <div class="flex flex-col items-stretch">
        <h2 class="text-3xl font-bold uppercase text-center pb-4">
            Certificados del evento {{ $evento->name }}
        </h2>
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200">
            Organizadores
        </h3>
        <div class="text-justify">
            <a class="inline-block p-3 bg-blue-500 text-white"
                href="{{ route('generar-organizadores', ['evento_id' => $evento_id]) }}">
                Generar certificados
            </a>
        </div>
        <ul class="flex flex-col items-stretch">
            @foreach ($organizadores as $organizador)
                <li class="p-3 flex flex-nowrap">
                    <p class="text-xl uppercase text-gray-900 grow">
                        {{ $organizador->paternal_surname }} {{ $organizador->maternal_surname }} {{ $organizador->name }}
                    </p>
                    @if ($organizador->pivot->certificado_creado)
                        @foreach ($certificados as $certificado)
                            @if ($certificado->tipo_id == 4 && $certificado->user_id == $organizador->id)
                                <a href="{{ route('documento', ['certificado_id' => $certificado->id]) }}"
                                    class="text-xl text-green-600 font-semibold p-2" target="_blank">
                                    Ver certificado
                                </a>
                                @break
                            @endif
                        @endforeach
                    @else
                        <span class="text-xl text-amber-600 font-semibold p-2">No creado</span>
                    @endif
                </li>
            @endforeach
        </ul>
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200 text-center">
            Ponentes
        </h3>
        <div class="text-center">
            <a class="inline-block p-3 bg-blue-500 text-white"
                href="{{ route('generar-ponentes', ['evento_id' => $evento_id]) }}">
                Generar certificados
            </a>
        </div>
        <ul class="flex flex-col items-stretch">
            @foreach ($ponentes as $p)
                <li class="p-4 flex flex-nowrap">
                    <div class="flex flex-col items-stretch grow">
                        <p class="py-1 text-xl uppercase text-gray-900">
                            {{ $p->paternal_surname }} {{ $p->maternal_surname }} {{ $p->name }}
                        </p>
                        <p class="px-7 text-md uppercase text-gray-700 italic">
                            {{ $p->pivot->ponencia }}
                        </p>
                    </div>
                    <div class="flex items-center justify-center">
                        @if ($p->pivot->certificado_creado)
                            @foreach ($certificados as $certificado)
                                @if ($certificado->tipo_id == 3 && $certificado->user_id == $p->id)
                                    <a href="{{ route('documento', ['certificado_id' => $certificado->id]) }}"
                                        class="text-xl text-green-600 font-semibold p-2" target="_blank">
                                        Ver certificado
                                    </a>
                                    @break
                                @endif
                            @endforeach
                        @else
                            <span class="text-xl text-amber-600 font-semibold p-2">No creado</span>
                        @endif
                    </div>
@endsection
