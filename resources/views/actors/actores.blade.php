<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Actores') }}
        </h2>
    </x-slot>

    <div class="py-4 contenedor">
        <div class="mx-auto">
            @if (Session::has('success'))
                <div class="bg-green-200 text-green-800 px-6 py-1 mb-4 rounded-md">
                    {{ Session::get('success') }}
                </div>
            @else
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif
            @endif
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <div class="p-0 mt-2">
                                    <a href="{{ route('createactor') }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        <i class="mdi mdi-plus"></i> Añadir
                                    </a>
                                </div>
                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_actores" id="tabla_actores">
                                    <thead>
                                        <tr class=" bg-gray-200">
                                            <th>ID</th>
                                            <th>NOMBRE</th>
                                            <th>AÑO NACIMIENTO</th>
                                            <th>LUGAR NACIMIENTO</th>
                                            <th>BIO</th>
                                            <th>IMAGEN</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($actores as $actor)
                                            <tr>
                                                <td><a href="{{ route('infoactor', $actor->id) }}"><i
                                                            class="mdi mdi-eye text-blue-600 mr-1"></i></a>{{ $actor->id }}
                                                </td>
                                                <td>{{ $actor->nombre }}</td>
                                                <td>{{ $actor->fecha_nacimiento }}</td>
                                                <td>{{ $actor->nacionalidad }}</td>
                                                <td>{{ $actor->bio }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/actors/' . $actor->imagen) }}"
                                                        alt="Sin imagen" class="w-20 h-20 object-contain">
                                                </td>
                                                <td>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="{{ route('editactor', $actor->id) }}"
                                                            class="bg-orange-400 text-white font-bold py-0 px-1 rounded flex items-center">
                                                            <i class="mdi mdi-pencil-outline text-lg"></i>
                                                        </a>
                                                        <form action="{{ route('deleteactor', $actor->id) }}"
                                                            method="POST" id="delete-form-{{ $actor->id }}"
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
