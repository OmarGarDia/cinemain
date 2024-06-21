<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Información de la pelicula ') }}
        </h2>
    </x-slot>
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="md:flex md:items-center">
                <div class="md:flex-shrink-0">
                    <img src="{{ asset('storage/movies/' . $movie->imagen) }}" alt="Sin imagen"
                        class="h-full w-full object-cover md:w-48 rounded-lg shadow-md">
                </div>
                <div class="md:ml-8 mt-4 md:mt-0">
                    <h1 class="text-2xl font-bold">{{ $movie->titulo }}</h1>
                    <div class="mt-2">
                        <span class="text-gray-600">Año de lanzamiento:</span>
                        <span class="ml-2 text-gray-800">{{ $movie->año }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Duración:</span>
                        <span class="ml-2 text-gray-800">{{ $movie->duracion }} min</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Género:</span>
                        <span class="ml-2 text-gray-800">{{ $movie->genero }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">País:</span>
                        <span class="ml-2 text-gray-800">{{ $movie->pais }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Fecha de estreno:</span>
                        <span
                            class="ml-2 text-gray-800">{{ \Carbon\Carbon::parse($movie->fecha_estreno)->format('d-m-Y') }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Director:</span>
                        <span class="ml-2 text-gray-800">Director Nombre</span>
                    </div>
                    <p class="mt-4 text-gray-700">{{ $movie->sinopsis }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 justify-center flex">
            <a href="{{ route('peliculas') }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><i
                    class="mdi mdi-arrow-left-thick"></i>
                Volver
            </a>
        </div>
    </div>
</x-app-layout>
