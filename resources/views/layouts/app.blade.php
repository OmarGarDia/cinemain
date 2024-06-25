<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

    <!-- Meta tag para la URL de búsqueda -->
    <meta name="search-movie-url" content="{{ route('searchmovie') }}">

    <!-- Incluir Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/misFunciones.js'])
</head>

<body class="font-sans antialiased h-screen overflow-hidden">
    <div class="h-full bg-white dark:border-gray-700 flex flex-col">
        <!-- Nav superior -->
        @include('layouts.navigation')

        <!-- Contenido -->
        <div class="flex flex-1 overflow-hidden">
            <!-- Aside -->
            <div class="w-1/6 border-gray-100 dark:bg-gray-800 border-b overflow-auto">
                <x-aside />
            </div>

            <!-- Contenido principal -->
            <div class="flex flex-col w-full overflow-auto">
                <!-- Header -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8"> <!-- Reducir py-6 a py-4 -->
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Slot -->
                <div class="flex-1">
                    <div class="border border-white px-2 m-0"> <!-- Reducir px-4 a px-2 -->
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
</body>

</html>
