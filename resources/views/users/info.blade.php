<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Seguimiento del usuario: ') . ' ' . $user->id . ' | ' . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 contenedor">
        <div class="mx-auto">
            @if (Session::has('success'))
                <div class="bg-green-200 text-green-800 px-6 py-4 mb-4 rounded-md">
                    {{ Session::get('success') }}
                </div>
            @endif
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <div class="text-xl font-semibold border-b-2 pb-2 mb-4 border-blue-700 text-blue-700">
                                    Películas que ha visto
                                </div>
                                @if ($peliculasVistas->isEmpty())
                                    <div class="bg-blue-100 p-4">
                                        Aún no tiene películas vistas.
                                    </div>
                                @else
                                    <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                        name="tabla_peliculas_vistas" id="tabla_peliculas_vistas">
                                        <thead>
                                            <tr class=" bg-gray-200">
                                                <th>ID</th>
                                                <th>TITULO</th>
                                                <th>AÑO</th>
                                                <th>SINOPSIS</th>
                                                <th>DURACION</th>
                                                <th>IDIOMA</th>
                                                <th>PAIS</th>
                                                <th>GENERO</th>
                                                <th>CALIFICA</th>
                                                <th>F.ESTRENO</th>
                                                <th>IMG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peliculasVistas as $pelicula)
                                                <tr class="border-y-2">
                                                    <td>{{ $pelicula->id }}</td>
                                                    <td>{{ $pelicula->titulo }}</td>
                                                    <td>{{ $pelicula->año }}</td>
                                                    <td>{{ $pelicula->sinopsis }}</td>
                                                    <td>{{ $pelicula->duracion }} min</td>
                                                    <td>{{ $pelicula->idioma }}</td>
                                                    <td>{{ $pelicula->pais }}</td>
                                                    <td>{{ $pelicula->genero }}</td>
                                                    <td>{{ $pelicula->calificacion }}/10</td>
                                                    <td>{{ $pelicula->fecha_estreno }}</td>
                                                    <td>{{ $pelicula->imagen }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </div>
                            <div class="overflow-x-auto mt-10">
                                <div class="text-xl font-semibold border-b-2 border-green-700 pb-2 mb-4 text-green-700">
                                    Películas pendientes de ver
                                </div>
                                @if ($peliculasPendientes->isEmpty())
                                    <div class="bg-green-100 p-4">
                                        Aún no tiene películas añadidas en la lista de pendientes.
                                    </div>
                                @else
                                    <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                        name="tabla_peliculas_pendiente" id="tabla_peliculas_pendiente">
                                        <thead>
                                            <tr class=" bg-gray-200 text-center">
                                                <th class="px-4 py-2 text-center">ID</th>
                                                <th class="px-4 py-2 text-center">TITULO</th>
                                                <th class="px-4 py-2 text-center">AÑO</th>
                                                <th class="px-4 py-2 text-center">SINOPSIS</th>
                                                <th class="px-4 py-2 text-center">DURACION</th>
                                                <th class="px-4 py-2 text-center">IDIOMA</th>
                                                <th class="px-4 py-2 text-center">PAIS</th>
                                                <th class="px-4 py-2 text-center">GENERO</th>
                                                <th class="px-4 py-2 text-center">CALIFICA</th>
                                                <th class="px-4 py-2 text-center">F.ESTRENO</th>
                                                <th class="px-4 py-2 text-center">IMG</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peliculasPendientes as $pelicula)
                                                <tr class="border-y-2">
                                                    <td>{{ $pelicula->id }}</td>
                                                    <td>{{ $pelicula->titulo }}</td>
                                                    <td>{{ $pelicula->año }}</td>
                                                    <td>{{ $pelicula->sinopsis }}</td>
                                                    <td>{{ $pelicula->duracion }} min</td>
                                                    <td>{{ $pelicula->idioma }}</td>
                                                    <td>{{ $pelicula->pais }}</td>
                                                    <td>{{ $pelicula->genero }}</td>
                                                    <td>{{ $pelicula->calificacion }}/5</td>
                                                    <td>{{ $pelicula->fecha_estreno }}</td>
                                                    <td>{{ $pelicula->imagen }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
