@extends('layouts.admin')

@section('contenido')
    <a href="{{ route('dashboard') }}">Volver</a>
    <form method="POST" action="{{ route('eventos.store') }}">
        @csrf

        <legend>Agregar Evento</legend>
        <div>
            <label for="name">
                Nombre:
            </label>
            <input required type="text" value="{{ old('name') }}" id="name" name="name" placeholder="Nombre del evento">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fecha">
                Fecha:
            </label>
            <input required type="date" value="{{ old('fecha') }}" id="fecha" name="fecha" placeholder="Fecha del evento">
            @error('fecha')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="address">
                Direccion:
            </label>
            <input type="text" id="address" value="{{ old('address') }}" name="address" placeholder="Direcion de envio">
            @error('address')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="url">
                URL:
            </label>
            <input required type="url" value="{{ old('url') }}" id="url" name="url" placeholder="URL del evento">
            @error('url')
                <p>{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit">Guardar</button>
    </form>
@endsection