@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        Detalles del Capítulo
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $titulo_serie }} - Temporada {{ $numTemporada }} -
                    Capítulo
                    {{ $episodio->episode_number }}</h2>
                <p class="text-gray-700 mb-4"><strong>Título:</strong> {{ $episodio->title }}</p>
                <p class="text-gray-700 mb-4"><strong>Sinopsis:</strong> {{ $episodio->sinopsis }}</p>
                <p class="text-gray-700 mb-4"><strong>Fecha de Estreno:</strong>
                    {{ \Carbon\Carbon::parse($episodio->fecha_estreno)->format('d M Y') }}</p>
                <div class="mt-4 flex justify-start">
                    <a href="{{ route('temporadainfo', ['idSerie' => $idSerie, 'idTemp' => $idTemp]) }}"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="mdi mdi-arrow-left-thick"></i> Volver a la Temporada
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
