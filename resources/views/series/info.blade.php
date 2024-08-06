@extends('layouts.app')

@section('header')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Información de la serie') }}
        </h2>
    </x-slot>
@endsection

@section('content')
    <div class="py-4 contenedor">
        @if (session('success'))
            <div class="bg-green-200 text-green-800 border border-green-300 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="md:flex md:items-start">
                <div class="md:flex-shrink-0">
                    <img src="{{ asset('storage/series/' . $serie->imagen) }}" alt="Sin imagen"
                        class="h-full w-full object-cover md:w-48 md:h-auto rounded-lg shadow-md">
                </div>
                <div class="md:ml-8 mt-4 md:mt-0">
                    <h1 class="text-2xl font-bold">{{ $serie->titulo }}</h1>
                    <div class="mt-2">
                        <span class="text-gray-600">Fecha de estreno:</span>
                        <span
                            class="ml-2 text-gray-800">{{ \Carbon\Carbon::parse($serie->fecha_estreno)->format('d-m-Y') }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Director:</span>
                        <span class="ml-2 text-gray-800">
                            <a class="text-blue-600 font-bold"
                                href="{{ route('serieinfo', $serie->director->id) }}">{{ $serie->director->nombre }}</a>
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="text-gray-600">Elenco:</span>
                        <div class="inline-flex items-center ml-2 space-x-2">
                            <a href="{{ route('elenco', $serie->id) }}"
                                class="bg-green-600 text-white px-1 py-0 rounded-full inline-flex items-center justify-center">
                                <i class="mdi mdi-plus"></i>
                            </a>
                            <span class="text-gray-800">
                                @foreach ($serie->actores as $actor)
                                    <div class="inline-flex items-center">
                                        <a href="{{ route('infoactor', $actor->id) }}"
                                            class="text-blue-600 font-bold">{{ $actor->nombre }}</a>
                                        <form
                                            action="{{ route('deleteActorFromSerie', ['serie' => $serie->id, 'actor' => $actor->id]) }}"
                                            method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    </div>
                                @endforeach
                            </span>
                        </div>
                    </div>
                    <p class="mt-4 text-gray-700">{{ $serie->descripcion }}</p>

                    <!-- Información de Temporadas -->
                    <div class="mt-6 flex items-center">
                        <h2 class="text-2xl font-bold text-gray-800">Temporadas:</h2>
                        <a href="{{ route('seasons', $serie->id) }}"
                            class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
                            <i class="mdi mdi-plus"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                        @foreach ($serie->seasons as $season)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold mb-2">Temporada {{ $season->season_number }}</h3>
                                    <p class="text-gray-600 mb-2"><strong>Nº de capítulos:</strong>
                                        {{ $season->episodes->count() }}</p>
                                    <p class="text-gray-600 mb-4">{{ $season->descripcion }}</p>
                                    <div class="flex space-x-1">
                                        <a href="{{ route('temporadainfo', ['idSerie' => $serie->id, 'idTemp' => $season->id]) }}"
                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-1 px-2 rounded inline-block">
                                            Ver Temporada
                                        </a>
                                        <form action="{{ route('deleteseason', $season->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 px-1 py-1 rounded">
                                                <i class="mdi mdi-delete text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-center">
            <a href="{{ route('series', $serie->id) }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="mdi mdi-arrow-left-thick"></i> Volver
            </a>
        </div>
    </div>
@endsection
