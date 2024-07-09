@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
        {{ __('Insertar Temporadas en ' . $serie->titulo) }}
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
                    <form method="POST" action="{{ route('storeseasons', $serie->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="seasons_count" class="block text-sm font-medium text-gray-700">Número de
                                    Temporadas</label>
                                <input type="number" id="seasons_count" name="seasons_count"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Insertar Temporadas
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
