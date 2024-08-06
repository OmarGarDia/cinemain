@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Películas por Género') }}
        </h2>
    </x-slot>

    <div class="py-4 contenedor">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($peliculas->isEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <p class="text-gray-600">No se encontraron películas para este género.</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($peliculas as $pelicula)
                        <li class="py-4 flex">
                            <img src="{{ asset('storage/movies/' . $pelicula->imagen) }}" alt="Sin imagen"
                                class="h-24 w-16 object-cover rounded-lg shadow-md">

                            <div class="ml-4">
                                <h3 class="text-lg font-bold">{{ $pelicula->titulo }}</h3>
                                <p class="text-gray-600">{{ $pelicula->año }}</p>
                                <p class="text-gray-600">{{ $pelicula->duracion }} min</p>
                                <p class="text-gray-600">{{ $pelicula->pais }}</p>
                                <a href="{{ route('movieinfo', $pelicula->id) }}"
                                    class="text-blue-600 font-bold mt-2 block">Ver detalles</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="mt-4 flex justify-center">
            <a href="{{ route('peliculas') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="mdi mdi-arrow-left-thick"></i> Volver
            </a>
        </div>
    </div>
@endsection
