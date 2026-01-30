@extends('layouts.admin')

@section('contenido')
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="w-full max-w-lg bg-white rounded-lg shadow-md p-8 border border-gray-200">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Certificado Base</h2>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 font-semibold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver al Dashboard
                </a>
            </div>

            <form method="POST" action="{{ route('store-certificado-base', ['evento_id' => $evento->id]) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-8">
                    <label for="base" class="block text-gray-700 font-bold mb-4 text-center text-lg">Certificado base:</label>
                    
                    <div class="flex justify-center">
                        <input type="file" name="base" id="base" accept="image/*" class="block w-full text-sm text-slate-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-violet-50 file:text-violet-700
                          hover:file:bg-violet-100
                        "/>
                    </div>
                    @error('base')
                        <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded shadow transition-colors duration-300">
                        Subir
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
