@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Información de la película') }}
        </h2>
    </x-slot>

    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="md:flex md:items-start">
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/movies/' . $movie->imagen) }}" alt="Sin imagen"
                        class="h-full w-full object-cover rounded-lg shadow-md">
                </div>
                <div class="md:w-2/3 md:ml-8 mt-4 md:mt-0">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $movie->titulo }}</h1>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <span class="text-gray-600">Año de lanzamiento:</span>
                            <span class="ml-2 text-gray-800">{{ $movie->año }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Duración:</span>
                            <span class="ml-2 text-gray-800">{{ $movie->duracion }} min</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-gray-600">Género:</span>
                            <span class="ml-2 text-gray-800">
                                @foreach ($generos as $genero)
                                    <a href="{{ route('peliculas.genero', ['genero' => $genero->id]) }}"
                                        class="text-blue-600 font-bold">{{ $genero->name }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-600">País:</span>
                            <span class="ml-2 text-gray-800">{{ $movie->pais }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Fecha de estreno:</span>
                            <span
                                class="ml-2 text-gray-800">{{ \Carbon\Carbon::parse($movie->fecha_estreno)->format('d-m-Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Director:</span>
                            <span class="ml-2 text-gray-800">
                                <a href="{{ route('infodirector', $movie->director->id) }}"
                                    class="text-blue-600 font-bold">{{ $movie->director->nombre }}</a>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-600">Elenco:</span>
                        <div class="inline-flex items-center ml-2 space-x-2">
                            <a href="{{ route('elenco', $movie->id) }}"
                                class="bg-green-600 text-white px-1 py-0 rounded-full inline-flex items-center justify-center">
                                <i class="mdi mdi-plus"></i>
                            </a>
                            <span class="text-gray-800">
                                @foreach ($movie->actores as $actor)
                                    <a href="{{ route('infoactor', $actor->id) }}"
                                        class="text-blue-600 font-bold">{{ $actor->nombre }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </span>
                        </div>
                        <p class="mt-4 text-gray-700">{{ $movie->sinopsis }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-center">
                <a href="{{ route('peliculas') }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="mdi mdi-arrow-left-thick"></i> Volver
                </a>
            </div>
        </div>
    @endsection
