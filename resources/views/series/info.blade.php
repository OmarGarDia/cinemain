<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Información de la serie') }}
        </h2>
    </x-slot>
    <div class="py-4 contenedor">
        <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-lg rounded-lg overflow-hidden p-6">
            <div class="md:flex md:items-start"> <!-- md:items-start para que la imagen esté arriba -->
                <div class="md:flex-shrink-0">
                    <img src="" alt="Sin imagen"
                        class="h-full w-full object-cover md:w-48 md:h-auto rounded-lg shadow-md">
                    <!-- object-cover para cubrir y md:w-48 para tamaño en dispositivos md -->
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
                        <span class="ml-2 text-gray-800"><a class="text-blue-600 font-bold"
                                href="{{ route('serieinfo', $serie->director->id) }}">{{ $serie->director->nombre }}</a></span>
                    </div>
                    {{-- <div class="mt-2">
                        <span class="text-gray-600">Elenco:</span>
                        <span class="ml-2 text-gray-800">
                            @php
                                $actorNames = $movie->actores->pluck('nombre')->implode(', ');
                            @endphp
                            @foreach ($movie->actores as $actor)
                                <a class="text-blue-600 font-bold" href="{{ route('infoactor', $actor->id) }}">
                                    {{ $actor->nombre }}
                                </a>
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </span>
                    </div> --}}
                    <p class="mt-4 text-gray-700">{{ $serie->descripcion }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-center"> <!-- flex justify-center para centrar el botón -->
            <a href="" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"><i
                    class="mdi mdi-arrow-left-thick"></i>
                Volver
            </a>
        </div>
    </div>
</x-app-layout>
