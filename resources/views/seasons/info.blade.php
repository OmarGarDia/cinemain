@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ $serieNombre }} - {{ $temporadaNombre }}
    </h2>
@endsection

@section('content')
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="mb-6">
                @if ($episodios->count() > 0)
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Temporada {{ $temporada->season_number }}</h2>
                        <ul class="divide-y divide-gray-200">
                            @foreach ($episodios as $episodio)
                                <li class="py-4">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-800">Episodio
                                                {{ $episodio->episode_number }}</h3>
                                            <p class="text-gray-700">{{ $episodio->title }}</p>
                                        </div>
                                        <div class="ml-4">
                                            <a href="#"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block">
                                                Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-orange-200 text-orange-700 border-l-4 border-orange-500 p-4 mb-4">
                        <p class="font-semibold">Esta temporada aún no dispone de capítulos.</p>
                    </div>
                @endif


                <div class="flex justify-start mb-4">
                    <a href="{{ route('addepisode', ['idSerie' => $serie->id, 'idTemp' => $temporada->id]) }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Añadir Capítulo
                    </a>
                </div>
            </div>
            <div class="mt-4 flex justify-center">
                <a href="{{ route('temporadainfo', ['idSerie' => $serie->id, 'idTemp' => $temporada->id]) }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="mdi mdi-arrow-left-thick"></i> Volver a la Temporada
                </a>
            </div>
        </div>
    </div>
@endsection
