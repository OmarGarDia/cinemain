@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Peliculas') }}
    </h2>
@endsection
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($peliculas as $pelicula)
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <img src="{{ asset('storage/movies/' . $pelicula->imagen) }}" alt="Sin imagen"
                    class="w-80 h-80 object-contain">
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $pelicula->titulo }}</h3>
                    <div class="sinopsis text-gray-600 text-sm mb-4">
                        <p class="truncate">{{ $pelicula->sinopsis }}</p>
                        @if (strlen($pelicula->sinopsis) > 100)
                            <a href="#" class="text-blue-500 cursor-pointer hover:underline leer-mas">Leer más</a>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 text-sm">{{ $pelicula->ano }}</span>
                        <span
                            class="ml-2 bg-gray-200 text-gray-700 text-sm px-2 py-1 rounded-full">{{ $pelicula->genero }}</span>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="" class="text-indigo-600 hover:text-indigo-800">Ver más</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/peliculasUsuarios.js') }}"></script>
@endsection
