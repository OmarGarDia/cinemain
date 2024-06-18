<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Insertar Pelicula') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-lg">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-800">
                    <div class="overflow-x-auto">
                        <form method="POST" action="{{ route('storemovie') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" name="titulo" id="titulo"
                                        value="{{ old('titulo', $peliculas->titulo) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="anio" class="block text-sm font-medium text-gray-700">Año</label>
                                    <input type="number" name="anio" id="anio"
                                        value="{{ old('anio', $peliculas->año) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="duracion" class="block text-sm font-medium text-gray-700">Duración
                                        (minutos)</label>
                                    <input type="number" name="duracion" id="duracion"
                                        value="{{ old('duracion', $peliculas->duracion) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="idioma" class="block text-sm font-medium text-gray-700">Idioma</label>
                                    <input type="text" name="idioma" id="idioma"
                                        value="{{ old('idioma', $peliculas->idioma) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                                    <input type="text" name="pais" id="pais"
                                        value="{{ old('pais', $peliculas->pais) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                                    <input type="text" name="genero" id="genero"
                                        value="{{ old('genero', $peliculas->genero) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="calificacion"
                                        class="block text-sm font-medium text-gray-700">Calificación</label>
                                    <input type="number" name="calificacion" id="calificacion" min="1"
                                        value="{{ old('calificacion', $peliculas->calificacion) }}" max="10"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_estreno" class="block text-sm font-medium text-gray-700">Fecha de
                                        Estreno</label>
                                    <input type="date" name="fecha_estreno" id="fecha_estreno"
                                        value="{{ old('fecha_estreno', $peliculas->fecha_estreno) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label for="sinopsis"
                                        class="block text-sm font-medium text-gray-700">Sinopsis</label>
                                    <textarea name="sinopsis" id="sinopsis"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        required>{{ old('sinopsis', $peliculas->sinopsis) }}</textarea>
                                </div>
                                <div>
                                    <label for="imagen_pelicula"
                                        class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" name="imagen_pelicula" id="imagen_pelicula"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        accept="image/*">
                                    @error('imagen_pelicula')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($peliculas->imagen)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Imagen Actual</label>
                                        <img src="{{ asset('storage/movies/' . $peliculas->imagen) }}"
                                            alt="Imagen de la película" class="mt-2 w-32 h-auto">
                                    </div>
                                @endif
                                <div class="flex items-center justify-between pt-4">
                                    <button type="submit"
                                        class="py-2 px-4 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                        Añadir
                                    </button>
                                    <a href="{{ route('peliculas') }}"
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
