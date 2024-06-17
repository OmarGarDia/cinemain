<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Peliculas') }}
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
                                <div class="p-0 mt-2">
                                    <a href="{{ route('addmovie') }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_peliculas" id="tabla_peliculas">
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
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($peliculas as $pelicula)
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
