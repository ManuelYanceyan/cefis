@extends('layouts.admin')

@section('contenido')
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-8 border border-gray-200">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Agregar Ponente</h2>
                <a href="{{ route('eventos.show', $evento_id) }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver
                </a>
            </div>

            <form method="POST" action="{{ route('store-ponente-evento', ['evento_id' => $evento_id]) }}">
                @csrf
                <input type="hidden" name="evento_id" value="{{ $evento_id }}">

                <div class="mb-6">
                    <label for="ponencia" class="block text-gray-700 font-bold mb-2">Título de la Ponencia:</label>
                    <input type="text" name="ponencia" id="ponencia" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 hover:border-blue-400 transition-colors" placeholder="Ingrese el título de la ponencia" required>
                </div>

                <div class="mb-6">
                    <label for="ponente" class="block text-gray-700 font-bold mb-2">Seleccionar Ponente:</label>
                    <div class="relative">
                        <select name="ponente" id="ponente" required class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
                            <option value="">-- Seleccione una persona --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->paternal_surname }} {{ $user->maternal_surname }} {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300 shadow">
                    Agregar Ponente
                </button>
            </form>
        </div>
    </div>
@endsection
