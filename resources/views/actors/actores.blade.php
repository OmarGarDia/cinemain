@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Actores') }}
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
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif
            @endif

            <div class="flex">
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <div class="p-0 mt-2">
                                    <a href="{{ route('createactor') }}"
                                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded shadow-lg transform hover:scale-105 transition-transform duration-200 ease-in-out hover:from-blue-600 hover:to-indigo-700">
                                        <i class="mdi mdi-plus"></i> Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse shadow-lg rounded-lg overflow-hidden"
                                    name="tabla_actores" id="tabla_actores">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                            <th class="px-4 py-2">ID</th>
                                            <th class="px-4 py-2">NOMBRE</th>
                                            <th class="px-4 py-2">AÑO NACIMIENTO</th>
                                            <th class="px-4 py-2">LUGAR NACIMIENTO</th>
                                            <th class="px-4 py-2">IMAGEN</th>
                                            <th class="px-4 py-2">OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($actores as $actor)
                                            <tr class="border-y-2">
                                                <td class="px-4 py-2"><a href="{{ route('infoactor', $actor->id) }}"><i
                                                            class="mdi mdi-eye text-blue-600 mr-1"></i></a>{{ $actor->id }}
                                                </td>
                                                <td class="px-4 py-2">{{ $actor->nombre }}</td>
                                                <td class="px-4 py-2">{{ $actor->fecha_nacimiento }}</td>
                                                <td class="px-4 py-2">{{ $actor->nacionalidad }}</td>
                                                <td class="px-4 py-2">
                                                    <img src="{{ asset('storage/actors/' . $actor->imagen) }}"
                                                        alt="Sin imagen" class="w-20 h-20 object-contain">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('editactor', $actor->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deleteactor', $actor->id) }}"
                                                            method="POST" id="delete-form-{{ $actor->id }}"
                                                            style="display: inline;" class="flex items-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="botonEliminar"
                                                                class="bg-red-500 text-white font-bold py-0 px-1 rounded">
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
