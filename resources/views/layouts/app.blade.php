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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Nav superior -->
        @include('layouts.navigation')

        <!-- Contenido -->
        <div class="flex">
            <!-- Aside -->
            <div class="w-1/6 border-gray-100 border-b">
                <x-aside />
            </div>

            <!-- Contenido principal -->
            <div class="flex flex-col w-full">
                <!-- Header -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8"> <!-- Reducir py-6 a py-4 -->
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Slot -->
                <div class="flex-1 dark:bg-white">
                    <div class="border border-white px-2"> <!-- Reducir px-4 a px-2 -->
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


</html>
