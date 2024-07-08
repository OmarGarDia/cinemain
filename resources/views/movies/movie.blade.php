@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Peliculas') }}
        </h2>
    </x-slot>

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
                            <div class="overflow-x-auto">
                                <div class="p-0 mt-2">
                                    <a href="{{ route('addmovie') }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i
                                            class="mdi mdi-plus"></i>
                                        Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_peliculas" id="tabla_peliculas">
                                    <thead>
                                        <tr class=" bg-gray-200">
                                            <th>ID</th>
                                            <th>TITULO</th>
                                            <th>AÑO</th>
                                            <th>DURACION</th>
                                            <th>IDIOMA</th>
                                            <th>PAIS</th>
                                            <th>GENERO</th>
                                            <th>CALIFICA</th>
                                            <th>F.ESTRENO</th>
                                            <th>DIRECTOR</th>
                                            <th>IMG</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peliculas as $pelicula)
                                            <tr class="border-y-2">
                                                <td><a href="{{ route('movieinfo', $pelicula->id) }}"><i
                                                            class="mdi mdi-eye text-blue-600 mr-1"></i></a>{{ $pelicula->id }}
                                                </td>
                                                <td>{{ $pelicula->titulo }}</td>
                                                <td>{{ $pelicula->año }}</td>
                                                <td>{{ $pelicula->duracion }} min</td>
                                                <td>{{ $pelicula->idioma }}</td>
                                                <td>{{ $pelicula->pais }}</td>
                                                <td>
                                                    {{ implode(', ', $pelicula->genres_array) }}
                                                </td>
                                                <td>{{ $pelicula->calificacion }}/10</td>
                                                <td>{{ $pelicula->fecha_estreno }}</td>
                                                <td class="text-blue-700"><a
                                                        href="{{ route('infodirector', $pelicula->director_id) }}">{{ $pelicula->director->nombre }}</a>
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/movies/' . $pelicula->imagen) }}"
                                                        alt="Sin imagen" class="w-20 h-20 object-contain">
                                                </td>
                                                <td>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('editarmovie', $pelicula->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deletemovie', $pelicula->id) }}"
                                                            method="POST" id="delete-form-{{ $pelicula->id }}"
                                                            style="display: inline;" class="flex items-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="botonEliminar"
                                                                class="bg-red-500 text-white font-bold py-0 px-1 rounded flex items-center">
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
