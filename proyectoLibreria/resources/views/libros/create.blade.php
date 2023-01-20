@extends('plantillas.uno')
@section('titulo')
    Crear Libro
@endsection
@section('cabecera')
    Crear Libro
@endsection
@section('contenido')
    <div class="w-1/2 p-4 rounded-lg shadow-lg bg-gray-100 mx-auto">
        <x-form action="{{ route('libros.store') }}">
            <x-form-input class="rounded" name="titulo" label="Título" placeholder="Título"/>
            <x-form-select class="rounded" name="user_id" label="Autor" :options="$users"/>
                {{--@foreach ($tipo as $item)
                    <option>{{$item}}</option>
                @endforeach
            </x-form-select> Esta es otra forma--}}
            <x-form-input class="rounded" type="number" step="0.01" min="0" max="100" name="pvp" label="Precio" placeholder="Precio (€)"/>
            <x-form-input class="rounded" type="number" step="1" name="stock" label="Stock" placeholder="Stock"/>
            <x-form-textarea class="rounded" name="resumen" label="Resumen" placeholder="Resumen del libro" />
            <div class="flex flex-row-reverse mt-2">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                    <i class="fas fa-check"></i> Crear
                </button>
                <a href="{{route("libros.index")}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left"></i> Volver
                </a> 
            </div>
        </x-form>
    </div>
@endsection
