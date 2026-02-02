@extends('layouts.admin')
@section('contenido')
    <div class="flex flex-col items-stretch">
        <h2 class="text-3xl font-bold uppercase text-center pb-4">
           {{ $evento->name }}
        </h2>
        <div class="py-3 my-4 w-full flex">
            @if ($evento->certificado_base != null)
                <a href="{{ route('admin-certificados', ['evento_id' => $evento_id]) }}"
                    class="text-lg font-bold p-3 bg-blue-500 text-white">
                    Certificados
                </a>
            @endif
            <div class="grow"></div>
            <a href="{{ route('add-certificado-base', ['evento_id' => $evento_id]) }}"
                class="text-lg font-bold p-3 bg-amber-500 text-white">
                Certificado base
            </a>
        </div>
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200">
            Organizadores
        </h3>
        <div class="flex items-center justify-evenly">
            <a class="inline-block p-3 bg-blue-500 text-white"
                href="{{ route('add-organizador', ['evento_id' => $evento_id]) }}">
                Agregar
            </a>
            <a class="inline-block p-3 bg-amber-500 text-gray-900 font-semibold"
                href="{{ route('exportar-organizadores', ['evento_id' => $evento_id]) }}">
                Exportar
            </a>
        </div>
        <ul class="flex flex-col items-stretch">
            @foreach ($organizadores as $organizador)
                <li class="p-3">
                    <p class="text-xl uppercase text-gray-900">
                        {{ $organizador->paternal_surname }} {{ $organizador->maternal_surname }} {{ $organizador->name }}
                    </p>
                </li>
            @endforeach
        </ul>
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200 text-center">
            Ponentes
        </h3>
        <div class="text-center">
            <a class="inline-block p-3 bg-blue-500 text-white"
                href="{{ route('add-ponente', ['evento_id' => $evento_id]) }}">
                Agregar ponente
            </a>
        </div>
        <ul class="flex flex-col items-stretch">
            @foreach ($ponentes as $p)
                <li class="p-4">
                    <p class="py-1 text-xl uppercase text-gray-900">
                        {{ $p->paternal_surname }} {{ $p->maternal_surname }} {{ $p->name }}
                    </p>
                    <p class="px-7 text-md uppercase text-gray-700 italic">
                        {{ $p->pivot->ponencia }}
                    </p>
                </li>
            @endforeach
        </ul>
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200 text-right">
            Asistentes
        </h3>
        @foreach ($asistentes as $a)
            <li>
                <p>
                    {{ $a->paternal_surname }} {{ $a->maternal_surname }} {{ $a->name }}
                </p>
            </li>
        @endforeach
        <h3 class="text-lg uppercase font-bold p-3 bg-gray-200 text-left">
            Pre inscritos
        </h3>
        @foreach ($preregistrados as $pre)
            <li>
                <p>
                    {{ $pre->paternal_surname }} {{ $pre->maternal_surname }} {{ $pre->name }}
                </p>
            </li>
        @endforeach
    </div>
@endsection
