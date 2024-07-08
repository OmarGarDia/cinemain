@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Insertar Actores a ' . $pelicula->titulo) }}
        </h2>
    </x-slot>

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
                    <form action="{{ route('store_actor_to_movie', $pelicula->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="actors" class="block text-sm font-medium text-gray-700">Seleccionar
                                Actores</label>
                            <select name="actor_ids[]" id="actors"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                multiple>
                                @foreach ($actores as $actor)
                                    <option value="{{ $actor->id }}">{{ $actor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="py-2 px-4 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">
                            Añadir Actores
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
