@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Insertar Actor/Actriz') }}
    </h2>
@endsection

@section('content')
    <div class="py-4">
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 px-6 py-1 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto max-w-lg">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-300">
                <div class="px-6 py-4 text-gray-900 dark:text-gray-800">
                    <div class="overflow-x-auto">
                        <form method="POST" action="{{ route('storeactor') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="search_actor" class="block text-sm font-medium text-gray-700">Buscar
                                        Actor/Actriz</label>
                                    <input type="text" id="search_actor"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <ul id="search_actor_results" class="list-group mt-2"></ul>
                                </div>
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="nombre" id="nombre"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_nac" class="block text-sm font-medium text-gray-700">Fecha de
                                        nacimiento</label>
                                    <input type="date" name="fecha_nac" id="fecha_nac"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400"
                                        required>
                                </div>
                                <div>
                                    <label for="lugar_nac" class="block text-sm font-medium text-gray-700">Lugar de
                                        nacimiento</label>
                                    <input type="text" name="lugar_nac" id="lugar_nac"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400"
                                        required>
                                </div>
                                <div>
                                    <label for="bio" class="block text-sm font-medium text-gray-700">Biografía</label>
                                    <textarea name="bio" id="bio"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400"
                                        required></textarea>
                                </div>
                                <div>
                                    <label for="imagen_actor" class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" name="imagen_actor" id="imagen_actor"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-400"
                                        required>
                                </div>
                                <div class="flex items-center justify-between pt-4">
                                    <button type="submit"
                                        class="py-2 px-4 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                        Añadir
                                    </button>
                                    <a href="{{ route('actores') }}"
                                        class="py-2 px-4 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
