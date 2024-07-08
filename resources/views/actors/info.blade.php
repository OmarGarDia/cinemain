@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ $actor->nombre }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="mx-auto max-w-7xl sm:px-4 lg:px-6">
            <div class="overflow-hidden bg-white border border-gray-300 shadow-lg rounded-lg">
                <div class="p-6 sm:px-12 bg-white border-b border-gray-200">
                    <div class="text-2xl dark:text-gray-800">
                        Información del Actor/Actriz
                    </div>

                    <div class="md:flex md:items-center pt-8">
                        <div class="md:flex-shrink-0">
                            <img src="{{ asset('storage/actors/' . $actor->imagen) }}" alt="Sin imagen"
                                class="h-full w-full object-cover md:w-48 rounded-lg shadow-md">
                        </div>
                        <div class="md:ml-8 mt-4 md:mt-0">
                            <h1 class="text-2xl font-bold">{{ $actor->nombre }}</h1>
                            <div class="mt-2">
                                <span class="text-gray-600">Fecha de nacimiento:</span>
                                <span
                                    class="ml-2 text-gray-800">{{ \Carbon\Carbon::parse($actor->fecha_nacimiento)->format('d-m-Y') }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Nacionalidad:</span>
                                <span class="ml-2 text-gray-800">{{ $actor->nacionalidad }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Peliculas donde actúa:</span>
                                <span class="ml-2 text-gray-800">{{ $numPeliculas }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Series donde actúa:</span>
                                <span class="ml-2 text-gray-800">{{ $numSeries }}</span>
                            </div>

                            <p class="mt-4 text-gray-700"></p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="text-2xl dark:text-gray-800">
                            Listado de Películas de {{ $actor->nombre }}
                        </div>

                        @if ($peliculas->isEmpty())
                            <div class="mt-4 bg-orange-200 text-orange-800 p-4 rounded">
                                De momento no ha actuado en ninguna película.
                            </div>
                        @else
                            <div
                                class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                @foreach ($peliculas as $pelicula)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                        <a href="{{ route('movieinfo', $pelicula->id) }}">
                                            <img src="{{ asset('storage/movies/' . $pelicula->imagen) }}"
                                                alt="{{ $pelicula->titulo }}" class="object-cover w-full h-48">
                                        </a>
                                        <div class="px-4 py-3">
                                            <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 truncate">
                                                {{ $pelicula->titulo }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-300">Año: {{ $pelicula->año }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $peliculas->links() }} <!-- Agregar paginación aquí -->
                            </div>
                        @endif
                    </div>

                    <div class="mt-8">
                        <div class="text-2xl dark:text-gray-800">
                            Listado de Series de {{ $actor->nombre }}
                        </div>

                        @if ($series->isEmpty())
                            <div class="mt-4 bg-orange-200 text-orange-800 p-4 rounded">
                                De momento no ha participado en ninguna serie.
                            </div>
                        @else
                            <div
                                class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                @foreach ($series as $serie)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                        <div class="px-4 py-3">
                                            <a href="{{ route('serieinfo', $serie->id) }}">
                                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 truncate">
                                                    {{ $serie->titulo }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-300">Año:
                                                    {{ $serie->fecha_estreno }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $series->links() }} <!-- Agregar paginación aquí -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
