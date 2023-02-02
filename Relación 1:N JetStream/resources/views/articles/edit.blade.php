<x-app-layout>
    <div class="py-20 bg-gradient-to-tr from-fuchsia-300 to-sky-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="mx-auto w-1/2 bg-gray-200 rounded shadow-lg px-2 py-4">
                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-jet-label class="mb-2 font-bold text-gray-900">Nombre</x-jet-label>
                    <x-jet-input type="text" name="nombre" class="w-full mb-3"
                        value="{{ old('nombre', $article->nombre) }}" />
                    <x-jet-input-error for="nombre" />

                    <x-jet-label class="mb-2 font-bold text-gray-900">Descripción</x-jet-label>
                    <textarea name="descripcion" rows="3"
                        class="my-2 mb-3 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500">
                        {{ old('descripcion', $article->descripcion) }}
                    </textarea>
                    <x-jet-input-error for="descripcion" />

                    <x-jet-label class="mb-2 font-bold text-gray-900">Precio (€)</x-jet-label>
                    <x-jet-input type="number" name="pvp" class="w-full mb-3" step="0.01"
                        value="{{ old('pvp', $article->pvp) }}" />
                    <x-jet-input-error for="pvp" />

                    <x-jet-label class="mb-2 font-bold text-gray-900">Stock</x-jet-label>
                    <x-jet-input type="number" name="stock" class="w-full mb-3"
                        value="{{ old('stock', $article->stock) }}" />
                    <x-jet-input-error for="stock" />

                    <x-jet-label class="my-2 font-bold text-gray-900" for="imagen">Imagen del Articulo</x-jet-label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 light:text-gray-400 focus:outline-none light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400"
                        id="imagen" name="imagen" type="file" accept="image/*">
                    <x-jet-input-error for="imagen" />
                    <div class="mt-5">
                        <img src="{{ Storage::url($article->imagen) }}" class="mx-auto rounded object-cover object-center"
                            width="300px" height="300px" id="img">
                    </div>
                    <div class="flex flex-row-reverse mt-2">
                        <button type="submit"
                            class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            <i class="fa-solid fa-edit"></i> Editar
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                            <i class="fa-solid fa-angle-left"></i> Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
