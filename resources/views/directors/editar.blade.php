<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Editar Director') }}
        </h2>
    </x-slot>
    <div class="py-4">
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 px-6 py-1 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mx-auto max-w-lg">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-800">
                    <div class="overflow-x-auto">
                        <form method="POST" action="{{ route('updatedirector', $director->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="nombre" id="nombre"
                                        value="{{ old('nombre', $director->nombre) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
                                        nacimiento</label>
                                    <input type="date" name="fecha_nac" id="fecha_nac"
                                        value="{{ old('fecha_nac', $director->fecha_nacimiento) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="lugar_nac" class="block text-sm font-medium text-gray-700">Lugar de
                                        nacimiento</label>
                                    <input type="text" name="lugar_nac" id="lugar_nac"
                                        value="{{ old('lugar_nac', $director->lugar_nacimiento) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                @if ($director->imagen)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Imagen Actual</label>
                                        <img src="{{ asset('storage/directors/' . $director->imagen) }}"
                                            alt="Imagen de la película" class="mt-2 w-32 h-auto">
                                    </div>
                                @endif
                                <div class="flex items-center justify-between pt-4">
                                    <button type="submit"
                                        class="py-2 px-4 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                        Añadir
                                    </button>
                                    <a href="{{ route('directores') }}"
                                        class="py-2 px-4 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
