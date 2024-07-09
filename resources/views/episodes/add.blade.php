@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Añadir Episodio a la temporada ' . $temporada->season_number) }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="mb-4">
                <label for="search_series" class="block text-gray-700 font-bold mb-2">Buscar Serie:</label>
                <input type="text" id="search_series" name="search_series"
                    class="mt-1 block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                <ul id="search_series_results" class="list-group"></ul>
            </div>
            <div class="mb-4" style="display: none;" id="seasons_container">
                <label for="seasons_select" class="block text-gray-700 font-bold mb-2">Temporadas:</label>
                <select id="seasons_select" name="seasons_select"
                    class="form-select w-full border-gray-300 rounded-lg px-3 py-2" required>
                    <option value="">Selecciona una temporada</option>
                </select>
            </div>
            <div class="mb-4" style="display: none;" id="episodes_container">
                <label for="episodes_select" class="block text-gray-700 font-bold mb-2">Episodios:</label>
                <select id="episodes_select" name="episodes_select"
                    class="form-select w-full border-gray-300 rounded-lg px-3 py-2" required>
                    <option value="">Selecciona un episodio</option>
                </select>
            </div>
            <form action="{{ route('storeepisode', ['idSerie' => $serie->id, 'idTemp' => $temporada->id]) }}"
                method="POST">
                @csrf
                <input type="hidden" name="serie_id" value="{{ $serie->id }}">
                <input type="hidden" name="season_id" value="{{ $temporada->id }}">
                <div class="mb-4">
                    <label for="episode" class="block text-gray-700 font-bold mb-2">Episodio:</label>
                    <input type="text" id="episode" name="episode"
                        class="form-input w-full border-gray-300 rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Título:</label>
                    <input type="text" id="title" name="title"
                        class="form-input w-full border-gray-300 rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="sinopsis" class="block text-gray-700 font-bold mb-2">Sinopsis:</label>
                    <textarea id="sinopsis" name="sinopsis" rows="4"
                        class="form-textarea w-full border-gray-300 rounded-lg px-3 py-2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="fecha_estreno" class="block text-gray-700 font-bold mb-2">Fecha de Estreno:</label>
                    <input type="date" id="fecha_estreno" name="fecha_estreno"
                        class="form-input w-full border-gray-300 rounded-lg px-3 py-2" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Añadir Episodio
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
