<x-app-layout>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="mb-2 flex flex-row-reverse">
                    <a href="{{route("articles.create")}}" class="px-6 py-2 text-gray-100 rounded bg-gradient-to-r from-green-300 via-blue-500 to-purple-600">
                        <i class="fa-solid fa-circle-plus"></i> Nuevo
                    </a>
                </div>
                <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Info
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descripcion
                            </th>
                            <th scope="col" class="px-3 py-3">
                                Precio
                            </th>
                            <th scope="col" class="px-3 py-3">
                                Stock
                            </th>
                            <th scope="col" class="px-14 py-3">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($article as $item)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="px-8 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('showPublic', $item) }}"
                                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        <i class="fa-solid fa-info"></i>
                                    </a>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->nombre }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->descripcion }}
                                </td>
                                <td class="px-3 py-4">
                                    {{ $item->pvp }}
                                </td>
                                <td class="px-3 py-4 text-center">
                                    {{ $item->stock }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('articles.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                        <a href="{{route('articles.edit', $item)}}"
                                            class="relative text-gray-900 bg-gradient-to-r from-lime-200 via-lime-400 to-lime-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $article->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
