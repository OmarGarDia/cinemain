@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ $director->nombre }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white border border-gray-300 shadow-lg rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl dark:text-gray-800">
                        Información del Director
                    </div>

                    <div class="md:flex md:items-center pt-8">
                        <div class="md:flex-shrink-0">
                            <img src="{{ asset('storage/directors/' . $director->imagen) }}" alt="Sin imagen"
                                class="h-full w-full object-cover md:w-48 rounded-lg shadow-md">
                        </div>
                        <div class="md:ml-8 mt-4 md:mt-0">
                            <h1 class="text-2xl font-bold">{{ $director->nombre }}</h1>
                            <div class="mt-2">
                                <span class="text-gray-600">Fecha de nacimiento:</span>
                                <span
                                    class="ml-2 text-gray-800">{{ \Carbon\Carbon::parse($director->fecha_nacimiento)->format('d-m-Y') }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Lugar de nacimiento:</span>
                                <span class="ml-2 text-gray-800">{{ $director->lugar_nacimiento }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Películas dirigidas:</span>
                                <span class="ml-2 text-gray-800">{{ $numPeliculas }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600">Series dirigidas:</span>
                                <span class="ml-2 text-gray-800">{{ $numSeries }}</span>
                            </div>

                            <p class="mt-4 text-gray-700"></p>

                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="text-2xl dark:text-gray-800">
                            Listado de Películas de {{ $director->nombre }}
                        </div>

                        @if ($peliculas->isEmpty())
                            <div class="mt-4 bg-orange-200 text-orange-800 rounded-md p-4">
                                De momento no ha dirigido ninguna película.
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
                                                {{ $pelicula->titulo }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-300">
                                                Año: {{ substr($pelicula->fecha_estreno, 0, 4) }}
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
                            Listado de Series de {{ $director->nombre }}
                        </div>

                        @if ($series->isEmpty())
                            <div class="mt-4 bg-orange-200 text-orange-800 rounded-md p-4">
                                De momento no ha dirigido ninguna serie.
                            </div>
                        @else
                            <div
                                class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                @foreach ($series as $serie)
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                        <a href="">
                                            <div class="px-4 py-3">
                                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200 truncate">
                                                    {{ $serie->titulo }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-300">
                                                    Año: {{ $serie->fecha_estreno }}
                                                </p>
                                            </div>
                                        </a>

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
