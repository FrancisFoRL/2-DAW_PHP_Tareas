<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('contacto.procesar') }}" method="POST">
                @csrf
                <x-jet-label class="my-2">Nombre</x-jet-label>
                <x-jet-input type="text" name="nombre" placeholder="Nombre" class="w-full"
                    value="{{ old('nombre') }}" />
                <x-jet-input-error for="nombre" />

                <x-jet-label class="my-2">Contenido</x-jet-label>
                <textarea name="contenido" rows="4"
                    class="my-2 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500">
                    {{ old('contenido') }}
                </textarea>
                <x-jet-input-error for="contenido" />
                <div class="flex flex-row-reverse mt-2">
                    <button type="submit"
                        class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        <i class="fa-sharp fa-solid fa-paper-plane"></i> Enviar
                    </button>
                    <a href="{{route('dashboard')}}"
                        class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        <i class="fa-solid fa-chevron-left"></i> Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>