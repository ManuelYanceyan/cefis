@extends('layouts.admin')

@section('title', 'Panel de Control')

@section('contenido')
    <h1>Bienvenido administrador</h1>
    <hr>
    <h2>Eventos</h2>
    <ul>
        @foreach ($eventos as $evento)
            <li>
                <a href="{{ route('evento', ['evento_id' => $evento->id]) }}" class="text-blue-600 hover:underline">
                    {{ $evento->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection