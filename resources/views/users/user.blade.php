<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-600 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12 contenedor">
        <div class="mx-auto">
            <!-- Flex container para alinear el aside a la izquierda -->
            <div class="flex">
                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden w-full">
                        <div class="px-6 text-gray-900 dark:text-gray-800 w-full">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full border-collapse border border-gray-200 text-sm"
                                    name="tabla_usuarios" id="tabla_usuarios">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="px-4 py-2">ID</th>
                                            <th class="px-4 py-2">NOMBRE</th>
                                            <th class="px-4 py-2">EMAIL</th>
                                            <th class="px-4 py-2">PASSWORD</th>
                                            <th class="px-4 py-2">CREADO</th>
                                            <th class="px-4 py-2">MODIFICADO</th>
                                            <th class="px-4 py-2">OPCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="text-center border-y-2">
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->password }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>{{ $user->updated_at }}</td>
                                                <td>
                                                    <button
                                                        class="bg-orange-400 text-white font-bold py-1 px-2 rounded"><i
                                                            class="mdi mdi-square-edit-outline"></i></button>
                                                    <button
                                                        class="bg-red-500 text-white font-bold py-1 px-2 rounded mr-2"><i
                                                            class="mdi mdi-trash-can-outline"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Añade más filas según sea necesario -->
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
