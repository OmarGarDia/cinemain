@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Peliculas') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="mx-auto">
            @if (Session::has('success'))
                <div class="bg-green-200 text-green-800 px-6 py-1 mb-4 rounded-md">
                    {{ Session::get('success') }}
                </div>
            @else
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif
            @endif
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div>
                                <div class="p-0 mt-2">
                                    <a href="{{ route('addmovie') }}"
                                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded shadow-lg transform hover:scale-105 transition-transform duration-200 ease-in-out hover:from-blue-600 hover:to-indigo-700">
                                        <i class="mdi mdi-plus mr-2"></i>
                                        Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse shadow-lg rounded-lg overflow-hidden"
                                    id="tabla_peliculas">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                            <th class="px-4 py-2">ID</th>
                                            <th class="px-4 py-2">TITULO</th>
                                            <th class="px-4 py-2">AÑO</th>
                                            <th class="px-4 py-2">DURACION</th>
                                            <th class="px-4 py-2">IDIOMA</th>
                                            <th class="px-4 py-2">PAIS</th>
                                            <th class="px-4 py-2">GENERO</th>
                                            <th class="px-4 py-2">CALIFICA</th>
                                            <th class="px-4 py-2">F.ESTRENO</th>
                                            <th class="px-4 py-2">DIRECTOR</th>
                                            <th class="px-4 py-2">IMG</th>
                                            <th class="px-4 py-2">ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peliculas as $pelicula)
                                            <tr class="border-b last:border-b-0 hover:bg-gray-100">
                                                <td class="px-4 py-2">
                                                    <a href="{{ route('movieinfo', $pelicula->id) }}">
                                                        <i class="mdi mdi-eye text-blue-600 mr-1"></i>{{ $pelicula->id }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2">{{ $pelicula->titulo }}</td>
                                                <td class="px-4 py-2">{{ $pelicula->año }}</td>
                                                <td class="px-4 py-2">{{ $pelicula->duracion }} min</td>
                                                <td class="px-4 py-2">{{ $pelicula->idioma }}</td>
                                                <td class="px-4 py-2">{{ $pelicula->pais }}</td>
                                                <td class="px-4 py-2">
                                                    {{ implode(', ', $pelicula->genres_array) }}
                                                </td>
                                                <td class="px-4 py-2">{{ $pelicula->calificacion }}/10</td>
                                                <td class="px-4 py-2">{{ $pelicula->fecha_estreno }}</td>
                                                <td class="px-4 py-2 text-blue-700">
                                                    <a href="{{ route('infodirector', $pelicula->director_id) }}">
                                                        {{ $pelicula->director->nombre }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <img src="{{ asset('storage/movies/' . $pelicula->imagen) }}"
                                                        alt="Sin imagen"
                                                        class="w-20 h-20 object-contain rounded-lg shadow-md">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('editarmovie', $pelicula->id) }}"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded-lg flex items-center justify-center transition duration-200">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deletemovie', $pelicula->id) }}"
                                                            method="POST" id="delete-form-{{ $pelicula->id }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="botonEliminar"
                                                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded-lg flex items-center justify-center transition duration-200">
                                                                <i class="mdi mdi-trash-can-outline text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
