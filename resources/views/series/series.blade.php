@extends('layouts.app')

@section('content')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Series') }}
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
                                    <a href="{{ route('createserie') }}"
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
                                            <th>TEMPORADAS</th>
                                            <th>F.ESTRENO</th>
                                            <th>DIRECTOR</th>
                                            <th>IMAGEN</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($series as $serie)
                                            <tr class="border-y-2">
                                                <td>
                                                    <a href="{{ route('serieinfo', ['serieId' => $serie->id]) }}">
                                                        <i class="mdi mdi-eye text-blue-600 mr-1"></i>
                                                    </a>
                                                    {{ $serie->id }}
                                                </td>
                                                <td>{{ $serie->titulo }}</td>
                                                <td>{{ $serie->seasons_count }}</td>
                                                <td>{{ $serie->fecha_estreno }}</td>
                                                <td class="text-blue-700"><a
                                                        href="{{ route('infodirector', $serie->director_id) }}">{{ $serie->director->nombre }}</a>
                                                </td>
                                                <td>
                                                    <img src="{{ asset('storage/series/' . $serie->imagen) }}"
                                                        alt="Sin imagen" class="w-20 h-20 object-contain">
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <!-- Contenido dentro del td -->
                                                        <a href="{{ route('editarserie', $serie->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deleteserie', $serie->id) }}"
                                                            method="POST" id="delete-form-{{ $serie->id }}"
                                                            class="flex items-center">
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
