@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 h-full">
        <div class="mx-auto h-full">
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex h-full">
                <!-- Main Content -->
                <div class="flex-1 h-full overflow-auto">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="px-6 text-gray-900 dark:text-gray-100 flex flex-wrap gap-4 justify-center h-full">
                            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                <div
                                    class="max-w-sm p-6 rounded-lg shadow dark:bg-red-400 dark:border-gray-700 flex justify-center items-center">

                                    <!-- Icono de película (cambiado por un ícono de FontAwesome) -->
                                    <div class="flex-shrink-0 mr-4">
                                        <span class="text-6xl dark:text-white mdi mdi-movie"></span>
                                    </div>

                                    <!-- Texto "400 Películas" -->
                                    <div class="text-center">
                                        <div class="text-5xl dark:text-white font-normal text-gray-700">
                                            {{ $peliculas }}
                                        </div>
                                        <div class="text-4xl dark:text-white font-normal text-gray-700">
                                            Peliculas
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                <div
                                    class="max-w-sm p-6 rounded-lg shadow dark:bg-blue-400 dark:border-gray-700 flex justify-center items-center">

                                    <!-- Icono de serie (cambiado por un ícono de FontAwesome) -->
                                    <div class="flex-shrink-0 mr-4">
                                        <span class="text-6xl dark:text-white mdi mdi-monitor"></span>
                                    </div>

                                    <!-- Texto "400 Series" -->
                                    <div class="text-center">
                                        <div class="text-5xl dark:text-white font-normal text-gray-700">
                                            {{ $series }}
                                        </div>
                                        <div class="text-4xl dark:text-white font-normal text-gray-700">
                                            Series
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                <div
                                    class="max-w-sm p-6 rounded-lg shadow dark:bg-green-400 dark:border-gray-700 flex justify-center items-center">

                                    <!-- Icono de serie (cambiado por un ícono de FontAwesome) -->
                                    <div class="flex-shrink-0 mr-4">
                                        <span class="text-6xl dark:text-white mdi mdi-camcorder"></span>
                                    </div>

                                    <!-- Texto "400 Series" -->
                                    <div class="text-center">
                                        <div class="text-5xl dark:text-white font-normal text-gray-700">
                                            0
                                        </div>
                                        <div class="text-4xl dark:text-white font-normal text-gray-700">
                                            Documentales (En Desarrollo)
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                <div
                                    class="max-w-sm p-6 rounded-lg shadow dark:bg-orange-400 dark:border-gray-700 flex justify-center items-center">

                                    <!-- Icono de serie (cambiado por un ícono de FontAwesome) -->
                                    <div class="flex-shrink-0 mr-4">
                                        <span class="text-6xl dark:text-white mdi mdi-camcorder"></span>
                                    </div>

                                    <!-- Texto "400 Series" -->
                                    <div class="text-center">
                                        <div class="text-5xl dark:text-white font-normal text-gray-700">
                                            {{ $users }}
                                        </div>
                                        <div class="text-4xl dark:text-white font-normal text-gray-700">
                                            Usuarios
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="mt-8 w-full text-center">
                                <p class="text-gray-600 text-3xl font-sans">Panel administrador para la gestión de la
                                    plataforma
                                    Cinemain
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
