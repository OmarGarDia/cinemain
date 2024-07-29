@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Directores') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="mx-auto">
            @if (Session::has('success'))
                <div class="bg-green-200 text-green-800 px-6 py-1 mb-4 rounded-md">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('error'))
                <div class="bg-red-200 text-red-800 px-6 py-1 mb-4 rounded-md">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="flex mb-6">
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <div class="p-0 mt-2">
                                    <a href="{{ route('createdirector') }}"
                                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded shadow-lg transform hover:scale-105 transition-transform duration-200 ease-in-out hover:from-blue-600 hover:to-indigo-700">
                                        <i class="mdi mdi-plus"></i> Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse shadow-lg rounded-lg overflow-hidden"
                                    name="tabla_directores" id="tabla_directores">
                                    <thead>
                                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                            <th class="px-4 py-2">ID</th>
                                            <th class="px-4 py-2">NOMBRE</th>
                                            <th class="px-4 py-2">AÑO NACIMIENTO</th>
                                            <th class="px-4 py-2">LUGAR NACIMIENTO</th>
                                            <th class="px-4 py-2">IMAGEN</th>
                                            <th class="px-4 py-2">ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($directores as $director)
                                            <tr class="border-b last:border-b-0 hover:bg-gray-100">
                                                <td class="px-4 py-2">{{ $director->id }}</td>
                                                <td class="px-4 py-2">{{ $director->nombre }}</td>
                                                <td class="px-4 py-2">{{ $director->fecha_nacimiento }}</td>
                                                <td class="px-4 py-2">{{ $director->lugar_nacimiento }}</td>
                                                <td class="px-4 py-2">
                                                    <img src="{{ asset('storage/directors/' . $director->imagen) }}"
                                                        alt="Sin imagen" class="w-20 h-20 object-contain">
                                                </td>
                                                <td class="px-4 py-2">
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('infodirector', $director->id) }}"
                                                            class="bg-blue-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-eye text-lg"></i>
                                                        </a>
                                                        <a href="{{ route('editdirector', $director->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deletedirector', $director->id) }}"
                                                            method="POST" id="delete-form-{{ $director->id }}"
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
