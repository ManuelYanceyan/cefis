@extends('layouts.admin')

@section('contenido')
<a href="{{route('evento',['evento_id'=>$evento_id])}}" class="p-3 bg-purple-500 text-white my-2 inline-block">
	Atras
</a>
<form method="post" enctype="multipart/form-data" class="mx-auto w-10/12 min-w-md max-w-lg p-4 border border-gray-200 shadow-md">
	@csrf
	<legend class="text-2xl text-center py-4">
		Certificado Base
	</legend>
	<div class="flex flex-col items-stretch">
		<label for="base" class="text-lg font-semibold">
			Certificado base:
		</label>
		<input class="p-3" required type="file" value="{{old('base')}}" id="base" name="base" placeholder="Certificado base">
		@error('base')
		<p class="p-3 text-red-500 text-lg">
			{{$message}}
		</p>
		@enderror
	</div>
	<div class="text-center">
		<button type="submit" class="p-2 px-3 bg-blue-500 text-white">
			Subir
		</button>
	</div>
</form>
@endsection
