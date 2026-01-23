@extends('layouts.admin')
@section('contenido')
<form method="POST" action="{{ route('login.post') }}" id="loginForm">
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px; padding: 10px; background-color: #ffebee; border: 1px solid #f44336; border-radius: 4px;">
            <strong>Errores:</strong>
            <ul style="list-style: none; padding: 0; margin: 5px 0 0 0;">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div>
        <label for="email">
            Email:
        </label>
        <input id="email" value="{{ old('email') }}" name="email" type="email" required>
    </div>
    <div>
        <label for="password">
            Password:
        </label>
        <input id="password" name="password" type="password" required>
        
        @error('password')
            <p style="color: red;">
                {{ $message }}
            </p>
        @enderror
    </div>
    <input type="submit" value="ingresar">
</form>
@endsection