@extends('plantillas.uno')
@section('titulo')
    Inicio Libros
@endsection
@section('cabecera')
    Lista de Libros
@endsection
@section('contenido')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex flex-row-reverse my-2">
            <a href="{{ route('libros.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-add"></i> Crear
            </a>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Info
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Titulo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio 
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stock
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($libros as $item)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('libros.show', $item) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-info"></i>
                            </a>
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->titulo }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->pvp }} €
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->stock }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('libros.destroy', $item)}}">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('libros.edit', $item) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="submit" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $libros->links() }}
    </div>
@endsection
@section('js')
    {{-- <script>
        Swal.fire({
            icon: 'success',
            title: "{{ session('mensaje') }}",
            showConfirmButton: false,
            timer: 1500
        })
    </script> --}}
@endsection
