<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Insertar Película') }}
        </h2>
    </x-slot>

    <div class="py-6">
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 px-6 py-2 mb-6 rounded-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto max-w-4xl">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-8 py-6">
                    <form method="POST" action="{{ route('updatemovie', $peliculas->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" name="titulo" id="titulo"
                                        value="{{ old('titulo', $peliculas->titulo) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="anio" class="block text-sm font-medium text-gray-700">Año</label>
                                    <input type="number" name="anio" id="anio"
                                        value="{{ old('anio', $peliculas->año) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="duracion" class="block text-sm font-medium text-gray-700">Duración
                                        (minutos)</label>
                                    <input type="number" name="duracion" id="duracion"
                                        value="{{ old('duracion', $peliculas->duracion) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="idioma" class="block text-sm font-medium text-gray-700">Idioma</label>
                                    <input type="text" name="idioma" id="idioma"
                                        value="{{ old('idioma', $peliculas->idioma) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                                    <input type="text" name="pais" id="pais"
                                        value="{{ old('pais', $peliculas->pais) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="generos"
                                        class="block text-sm font-medium text-gray-700">Géneros</label>
                                    <select name="generos[]" id="generos" multiple
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        @foreach ($generos as $genero)
                                            <option value="{{ $genero->id }}"
                                                {{ in_array($genero->id, $generosSeleccionados) ? 'selected' : '' }}>
                                                {{ $genero->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="calificacion"
                                        class="block text-sm font-medium text-gray-700">Calificación</label>
                                    <input type="number" name="calificacion" id="calificacion" min="1"
                                        max="10" step="0.1"
                                        value="{{ old('calificacion', $peliculas->calificacion) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_estreno" class="block text-sm font-medium text-gray-700">Fecha de
                                        Estreno</label>
                                    <input type="date" name="fecha_estreno" id="fecha_estreno"
                                        value="{{ old('fecha_estreno', $peliculas->fecha_estreno) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="director_id"
                                        class="block text-sm font-medium text-gray-700">Director</label>
                                    <select name="director_id" id="director_id"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                        <option value="">Seleccionar Director</option>
                                        @foreach ($directores as $director)
                                            <option value="{{ $director->id }}"
                                                {{ $peliculas->director_id == $director->id ? 'selected' : '' }}>
                                                {{ $director->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="sinopsis"
                                        class="block text-sm font-medium text-gray-700">Sinopsis</label>
                                    <textarea name="sinopsis" id="sinopsis"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>{{ old('sinopsis', $peliculas->sinopsis) }}</textarea>
                                </div>
                                <div>
                                    <label for="imagen_pelicula"
                                        class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" name="imagen_pelicula" id="imagen_pelicula"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                @if ($peliculas->imagen)
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700">Imagen Actual</label>
                                        <img src="{{ asset('storage/movies/' . $peliculas->imagen) }}"
                                            alt="Imagen de la película" class="mt-2 w-32 h-auto">
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between pt-6">
                                <button type="submit"
                                    class="py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
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
</x-app-layout>
