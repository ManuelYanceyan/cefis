@extends('layouts.admin')
@section('contenido')
    <div class="flex items-center justify-center min-h-[80vh]">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h2>

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Errores:</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">
                        Email:
                    </label>
                    <input id="email" value="{{ old('email') }}" name="email" type="email" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 hover:border-amber-400 transition-colors">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-bold mb-2">
                        Password:
                    </label>
                    <input id="password" name="password" type="password" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 hover:border-amber-400 transition-colors">
                    
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-amber-500 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
@endsection