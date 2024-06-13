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
                                <div class="text-xl font-semibold border-b-2 pb-2 mb-4">
                                    <!-- Clases para el tamaño, el peso de la fuente, el subrayado y el espaciado -->
                                    Películas que ha visto
                                </div>

                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_peliculas_vistas" id="tabla_peliculas_vistas">
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
                                            <th class="px-4 py-2 text-center">ACCION</th>
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
                                                <td>{{ $pelicula->calificacion }}/5</td>
                                                <td>{{ $pelicula->fecha_estreno }}</td>
                                                <td>{{ $pelicula->imagen }}</td>
                                                <td>
                                                    <div class="flex items-center space-x-2">
                                                        <a href=""
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="" method="POST"
                                                            id="delete-form-{{ $pelicula->id }}"
                                                            style="display: inline;" class="flex items-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button id="botonEliminar"
                                                                class="bg-red-500 text-white font-bold py-0 px-1 rounded flex items-center">
                                                                <i class="mdi mdi-trash-can-outline text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
