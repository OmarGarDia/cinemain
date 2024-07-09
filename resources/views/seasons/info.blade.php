@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ $serieNombre }} - {{ $temporadaNombre }}
    </h2>
@endsection

@extends('layouts.app')

@section('content')
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="mb-6">
                @if ($hayCapitulos)
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $temporadaNombre }}</h2>
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Capítulos:</h3>
                        <ul>
                            @foreach ($capitulos as $capitulo)
                                <li class="mb-2">
                                    <strong>Número:</strong> {{ $capitulo->numero }} - <strong>Título:</strong>
                                    {{ $capitulo->titulo }}
                                    <a href=""
                                        class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-1 px-2 rounded inline-block ml-2">
                                        Ver Detalles
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-orange-200 text-orange-700 border-l-4 border-orange-500 p-4 mb-4">
                        <p>Esta temporada aún no dispone de capítulos.</p>
                    </div>
                @endif
                <div class="flex justify-end mb-4">
                    <a href="{{ route('addepisode', ['idSerie' => $idSerie, 'idTemp' => $idTemp]) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Añadir Capítulo
                    </a>
                </div>
            </div>
            <div class="mt-4 flex justify-center">
                <a href="{{ route('temporadainfo', ['idSerie' => $idSerie, 'idTemp' => $idTemp]) }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="mdi mdi-arrow-left-thick"></i> Volver a la Temporada
                </a>
            </div>
        </div>
    </div>
@endsection
