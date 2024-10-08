@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
        {{ __('Insertar Serie') }}
    </h2>
@endsection

@section('content')
    <div class="py-6">
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 px-6 py-2 mb-6 rounded-lg shadow-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto max-w-4xl">
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-300">
                <div class="px-8 py-6">
                    <form method="POST" action="{{ route('updateserie', $series->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="search_serie" class="block text-sm font-medium text-gray-700">Buscar
                                    Serie</label>
                                <input type="text" id="search_serie"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                <ul id="search_serie_result" class="list-group"></ul>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                                    <input type="text" name="titulo" id="titulo"
                                        value="{{ old('titulo', $series->titulo) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <div>
                                    <label for="fecha_estreno" class="block text-sm font-medium text-gray-700">Fecha
                                        Estreno</label>
                                    <input type="number" name="fecha_estreno" id="fecha_estreno"
                                        value="{{ old('fecha_estreno', $series->fecha_estreno) }}"
                                        class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label for="director_id" class="block text-sm font-medium text-gray-700">Director</label>
                                <select name="director_id" id="director_id"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                    <option value="">Seleccionar Director</option>
                                    @foreach ($directores as $director)
                                        <option value="{{ $director->id }}"
                                            {{ $series->director_id == $director->id ? 'selected' : '' }}>
                                            {{ $director->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="descripcion" id="descripcion"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>{{ old('descripcion', $series->descripcion) }}</textarea>
                            </div>
                            <div>
                                <label for="imagen_serie" class="block text-sm font-medium text-gray-700">Imagen</label>
                                <input type="file" name="imagen_serie" id="imagen_serie"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>
                            @if ($series->imagen)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Imagen Actual</label>
                                    <img src="{{ asset('storage/series/' . $series->imagen) }}" alt="Imagen de la película"
                                        class="mt-2 w-32 h-auto">
                                </div>
                            @endif
                            <div class="flex items-center justify-between pt-6">
                                <button type="submit"
                                    class="py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                                    Añadir
                                </button>
                                <a href="{{ route('series') }}"
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
@endsection
